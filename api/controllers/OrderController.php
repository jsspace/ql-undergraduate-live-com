<?php

namespace api\controllers;

use backend\models\Book;
use backend\models\BookOrder;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use common\models\User;
use backend\models\Course;
use backend\models\CourseCategory;
use backend\models\CoursePackage;
use backend\models\Coupon;
use backend\models\Coin;
use yii\helpers\Url;
use backend\models\Cart;
use backend\models\OrderGoods;
use backend\models\OrderInfo;
use backend\models\Lookup;
use yii\rest\ActiveController;
use common\controllers\ApiController;

require_once "../../common/xcx_wxpay/lib/WxPay.Api.php";
require_once "../../common/xcx_wxpay/example/WxPay.NativePay.php";
require_once '../../common/xcx_wxpay/example/log.php';
require_once "../../common/xcx_wxpay/lib/WxPay.Config.php";

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class OrderController extends ActiveController
{
    public $modelClass = 'backend\models\OrderInfo';
    
    /* 过滤器实现认证 */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticatior' => [
                'class' => QueryParamAuth::className()
            ]
        ]);
    }
    
    public function actionOrderinfo()
    {
        $get = Yii::$app->request->get();
        $order_sn = $get['order_sn'];
        $access_token = $get['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $user_id = $user->id;
        
        $order_info = OrderInfo::find()
        ->where(['order_sn' => $order_sn])
        ->andWhere(['user_id' => $user_id])
        ->asArray()
        ->one();
        if (empty($order_info)) {
            $data = [
                'code' => -1,
                'message' => '没有查到订单信息',
            ];
            return $data;
        }
        
        $coupon = Coupon::find()
        ->where(['user_id' => $user_id])
        ->andWhere(['isuse' => 0])
        ->andWhere(['>','end_time', date('Y-m-d H:i:s',time())])
        ->asArray()
        ->all();
        
        $coin = Coin::find()
        ->where(['userid' => $user_id])
        ->andWhere(['>', 'balance', 0])
        ->orderBy('id desc')
        ->asArray()
        ->one();
        
        $data = [
            'code' => 0,
            'order_info' => $order_info,
            'coupon' => $coupon,
            'coin' => $coin,
        ];
        return $data;
    }

    //课程信息接口
    public function actionCourseinfo()
    {
        $post = Yii::$app->request->Post();
        $course_id = $post['course_id'];
        $course_data = Course::find()
        ->where(['id' => $course_id])
        ->andWhere(['onuse' => 1])
        ->asArray()
        ->one();
        if (!empty($course_data)) {
            $course_data['home_pic'] = Url::to('@web'.$course_data['home_pic'], true);
            $course_data['list_pic'] = Url::to('@web'.$course_data['list_pic'], true);
            $data = [
                'code' => 0,
                'course' => $course_data,
            ];
        } else {
            $data = [
                'code' => 1,
                'message' => '没有数据',
            ];
        }
        return $data;
    }
    
    public function actionConfirmOrder1()
    {
        $get = Yii::$app->request->get();
        $order_sn = $get['order_sn'];
        $access_token = $get['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $user_id = $user->id;
        
        $orderInfo = OrderInfo::find()
        ->where(['order_sn' => $order_sn])
        ->andWhere(['user_id' => $user_id])
        ->andWhere(['pay_status' => 0])
        ->one();
        if (!empty($orderInfo)) {
            return $this->render('payok', ['order_sn' => $order_sn, 'order_amount' => $orderInfo->order_amount]);
        }
        $data = Yii::$app->request->Post();
        if (!isset($data['coupon_ids']) || !isset($data['course_ids']) || !isset($data['course_package_ids'])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if (empty($data['course_ids']) && empty($data['course_package_ids'])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $goods_amount = 0.00;
        $coupon_ids = explode(',', $data['coupon_ids']);
        $coupon_money = 0.00;
        $coupons = Coupon::find()
        ->where(['user_id' => $user_id])
        ->andWhere(['coupon_id' => $coupon_ids])
        ->andWhere(['isuse' => 0])
        ->andWhere(['>', 'end_time', date('Y-m-d H:i:s', time())])
        ->all();
        $coupon_ids_str = '';
        foreach($coupons as $model) {
            $coupon_ids_str .= $model->coupon_id;
            $coupon_money += $model->fee;
            //标记优惠券正在使用中
            $model->isuse = 1;
            $model->save(false);
        }
        
        $course_ids = explode(',', $data['course_ids']);
        //删除购物车中对应的条目
        Cart::deleteAll([
            'product_id' => $course_ids, 
            'user_id' => $user_id,
        ]);
        $course_models = Course::find()
        ->where(['id' => $course_ids])
        ->andWhere(['onuse' => 1])
        ->all();
        $courseids = '';
        foreach($course_models as $model) {
            $courseids .= $model->id . ',';
        }
        //添加课程订单商品
        foreach($course_models as $model) {
            $order_goods = new OrderGoods();
            $order_goods->order_sn = $order_sn;
            $order_goods->goods_id = $model->id;
            $order_goods->goods_name = $model->course_name;
            $order_goods->goods_number = 1;
            $order_goods->market_price = $model->price;
            $order_goods->goods_price = $model->discount;
            $order_goods->type = 'course';
            $order_goods->save(false);
            $goods_amount += $model->discount;
        }
        $course_package_ids = explode(',', $data['course_package_ids']);
        //删除购物车中对应的条目
        Cart::deleteAll([
            'product_id' => $course_package_ids,
            'user_id' => $user_id,
        ]);
        $course_package_models = CoursePackage::find()
        ->where(['id' => $course_package_ids])
        ->andWhere(['onuse' => 1])
        ->all();
        foreach($course_package_models as $model) {
            $courseids .= $model->course . ',';
        }
        //添加班级订单商品
        foreach($course_package_models as $model) {
            $order_goods = new OrderGoods();
            $order_goods->order_sn = $order_sn;
            $order_goods->goods_id = $model->id;
            $order_goods->user_id = $user_id;
            $order_goods->pay_status = 0;
            $order_goods->goods_id = $model->id;
            $order_goods->goods_name = $model->name;
            $order_goods->goods_number = 1;
            $order_goods->market_price = $model->price;
            $order_goods->goods_price = $model->discount;
            $order_goods->type = 'course_package';
            $order_goods->save(false);
            $goods_amount += $model->discount;
        }
        
        $course_ids_arr = explode(',', $courseids);
        $course_ids_str = implode(',', array_unique($course_ids_arr));
        
        //查看此人是否是被邀请注册的
        $invite = $user_identity->invite;
        //查看是否是第一次购买
        $is_first_order = OrderInfo::find()
        ->andWhere(['user_id' => $user_id])
        ->andWhere(['pay_status' => 2])
        ->count();
        if ($invite > 0 && $is_first_order == 0) {
            $perc = Lookup::find()
            ->where(['type' => 'share_course_shoping_get'])
            ->one();
            $order_amount = ((100 - $perc) / 100.00) * $goods_amount - $coupon_money;
        } else {
            $order_amount = $goods_amount - $coupon_money;
        }
        
        
        $pay_status = 0;
        $bonus = 0;/*使用钱包金额*/
        /*是否使用钱包*/
        $wallet_pay = 0;/*默认钱包支付 标记为0*/
        $use_wallet = $data['use_wallet'];
        $coin = new Coin();
        if ($use_wallet == 1) {
            $coin->userid = $user_id;
            $coin->card_id = $order_sn;
            $coin->operation_time = time();
            /*钱包余额*/
            $my_wallet = $data['my_wallet'];
            /*钱包金额够支付订单的*/
            if ($order_amount <= $my_wallet) {
                /*标记钱包支付*/
                $wallet_pay = 1;
                /*钱包中减去此次订单总额*/
                $coin->income = -$order_amount;
                $coin->balance = $my_wallet-$order_amount;
                $coin->operation_detail = '购买课程花费'.$order_amount.'元';
                $bonus = $order_amount;
                $order_amount = 0;
                $pay_status = 2;
            } else {
                $order_amount = $order_amount-$my_wallet;
                $coin->income = -$my_wallet;
                $coin->balance = 0;
                $coin->operation_detail = '购买课程花费'.$my_wallet.'元';
                $bonus = $my_wallet;
            }
            $coin->save(false);
        }
        //添加订单信息
        $order_info = new OrderInfo();
        if ($wallet_pay === 1) {
            $order_info->pay_time = time();
        }
        $order_info->order_sn = $order_sn;
        $order_info->user_id = $user_id;
        $order_info->order_status = 1;
        $order_info->pay_status = $pay_status;
        $order_info->consignee = $user_identity->username;
        $order_info->mobile = $user_identity->phone;
        $order_info->email = $user_identity->email;
        //0 1支付宝 2 微信
        $order_info->pay_id = 0;
        $order_info->goods_amount = $goods_amount;
        $order_info->order_amount = $order_amount;
        $order_info->add_time = time();
        $order_info->course_ids = $course_ids_str;
        $order_info->coupon_ids = $coupon_ids_str;
        $order_info->coupon_money = $coupon_money;
        $order_info->bonus = $bonus;
        $order_info->save(false);
        return $this->render('payok', ['order_sn' => $order_sn, 'order_amount' => $order_amount, 'wallet_pay' => $wallet_pay]);
    }


    //确认订单接口
    public function actionConfirmOrder()
    {
        $data = Yii::$app->request->get();
        //唯一订单号码（KB-YYYYMMDDHHIISSNNNNNNNNCC）
        $order_sn = $this->createOrderid();
        $access_token = $data['access-token'];
        $type = $data['type'];
        $user = User::findIdentityByAccessToken($access_token);
        $user_id = $user->id;

        $username = $data['username'];
        $phone = $data['phone'];
        $address = $data['address'];
        if (empty($data['course_id'])) {
            $data = [
                'code' => -1,
                'message' => 'course_id参数为空'
            ];
            return $data;
        }
        $course_id = $data['course_id'];
        $order = OrderInfo::find()->where(['user_id' => $user_id, 'course_ids' => $course_id])
            ->andWhere(['>','invalid_time', time()])->one();

        // if (!empty($order)) {
        //     $data = [
        //         'code' => -1,
        //         'message' => '有相关未完成订单'
        //     ];
        //     return $data;
        // }

        if ($type == 'course') {
            $course_models = Course::find()
                ->where(['id' => $course_id])
                ->andWhere(['onuse' => 1])
                ->all();
        } else {
            $course_models = CoursePackage::find()
                ->where(['id' => $course_id])
                ->andWhere(['onuse' => 1])
                ->all();
        }

        if (empty($course_models)) {
            $data = [
                'code' => -2,
                'message' => '课程数据为空'
            ];
            return $data;
        }
        //删除购物车中对应的条目
        Cart::deleteAll([
            'product_id' => [$course_id],
            'user_id' => $user_id,
        ]);
        $goods_amount = 0.00;
        //添加课程订单商品
        foreach($course_models as $model) {
            $order_goods = new OrderGoods();
            $order_goods->user_id = $user_id;
            $order_goods->order_sn = $order_sn;
            $order_goods->goods_id = $model->id;
            $order_goods->goods_number = 1;
            $order_goods->market_price = $model->price;
            $order_goods->goods_price = $model->discount;
            if ($type == 'course') {
                $order_goods->type = $type;
                $order_goods->goods_name = $model->course_name;
            } else {
                $order_goods->type = 'course_package';
                $order_goods->goods_name = $model->name;
            }
            $order_goods->save(false);
            $goods_amount += $model->discount;
        }
        //查看此人是否是被邀请注册的
        $invite = $user->invite;
        //查看是否是第一次购买
        $order_count = OrderInfo::find()
        ->andWhere(['user_id' => $user_id])
        ->andWhere(['pay_status' => 2])
        ->count();
        // if ($invite > 0 && $order_count == 0) {
        //     //被邀请会员第一次购买有优惠
        //     $perc =Lookup::find()
        //     ->where(['type' => 'share_course_discount'])
        //     ->one();
        //     $order_amount = ((100 - $perc->code) / 100.00) * $goods_amount;
        // } else {
        //     $order_amount = $goods_amount;
        // }
        $order_amount = $goods_amount;
        //添加订单信息
        $order_info = new OrderInfo();
        $order_info->order_sn = $order_sn;
        $order_info->user_id = $user_id;
        $order_info->order_status = 1;
        $order_info->pay_status = 0;
        $order_info->consignee = $user->username;
        $order_info->mobile = $user->phone;
        $order_info->email = $user->email;
        //0 1支付宝 2 微信
        $order_info->pay_id = 0;
        $order_info->goods_amount = $goods_amount;
        $order_info->order_amount = $order_amount;
        $order_info->add_time = time();
        $order_info->invalid_time = time() +3600 * 24 * 180;
        if ($type == 'course') {
            $order_info->course_ids = $course_id;
        } else {
            $pack = CoursePackage::find()->select('course')->where(['id' => $course_id])->one();
            $order_info->course_ids = $pack->course;
        }

        // 保存收货信息
        $order_info->address = '用户名:' . $username . ', 手机号:' . $phone . ', 收货地址:' . $address;
        // 保存赠送书籍
        $order_info->gift_books = $data['gift_books'];

        $order_info->coupon_ids = '';
        $order_info->coupon_money = 0;
        $order_info->bonus = 0;
        $order_info->save(false);
        
        $data = [
            'code' => 0,
            'order_sn' => $order_sn,
        ];
        return $data;
    }

    public function actionPay($coupon_id = -1, $use_coin = 0)
    {
        $get = Yii::$app->request->get();
        $order_sn = $get['order_sn'];
        $access_token = $get['access-token'];
        $code = $get['code'];
        $user = User::findIdentityByAccessToken($access_token);
        $user_id = $user->id;
        
        $orderInfo = OrderInfo::find()
        ->where(['order_sn' => $order_sn])
        ->andWhere(['user_id' => $user_id])
        ->andWhere(['order_status' => 1])
        ->andWhere(['pay_status' => 0])
        ->one();
        if (empty($orderInfo)) {
            $data = [
                'code' => -1,
                'message' => '不存在这个订单或者此订单已支付'
            ];
            return $data;
        }
        
        $coupon = Coupon::find()
        ->where(['user_id' => $user_id])
        ->andWhere(['coupon_id' => $coupon_id])
        ->andWhere(['isuse' => 0])
        ->andWhere(['>','end_time', date('Y-m-d H:i:s',time())])
        ->one();
        $coupon_pay = 0.00;
        if (!empty($coupon)) {
            if ($coupon->fee >= $orderInfo->order_amount) {
                //标记优惠券已使用
                $coupon->isuse = 2;
                $coupon->save(false);
                $order_info->pay_name = '优惠券支付';
                $orderInfo->coupon_ids = $coupon_id;
                $orderInfo->coupon_money = $coupon->fee;
                $orderInfo->pay_status = 2;
                $orderInfo->pay_time = time();
                $order_info->save(false);
                OrderGoods::updateAll(['pay_status' => 2], ['order_sn' => $order_sn]);
                
                
                //给邀请人发送奖励金额
                //查看此人是否是被邀请注册的
                $invite_peaple = User::find()
                ->where(['id' => $user_id])
                ->one();
                $invite = $invite_peaple->invite;
                //查看是否是第一次购买
                $is_first_order = OrderInfo::find()
                ->andWhere(['user_id' => $user_id])
                ->andWhere(['pay_status' => 2])
                ->count();
                if ($invite > 0 && $is_first_order == 0) {
                    $perc = Lookup::find()
                    ->where(['type' => 'share_course_shoping_get'])
                    ->one();
                    // 收入
                    $income = ($perc->code / 100.00) * $order_info->goods_amount;
                    //分享人报酬
                    $invite_pay = new Coin();
                    $invite_pay->userid = $invite;
                    $invite_pay->income = $income;
                    $invite_pay->balance = $income;
                    $invite_pay->operation_detail = '邀请注册首单奖励，邀请的用户： ' . $invite_peaple->username;
                    $invite_pay->operation_time = time();
                    $invite_pay->card_id = $order_info->order_sn;
                    $invite_pay->save(false);
                }
                
                $data = [
                    'code' => 0,
                    'wxpay' => 0,
                    'message' => '支付成功'
                ];
                return $data;
                
            } else {
                $coupon_pay = $coupon->fee;
            }
            
        }
        
        $coin = Coin::find()
        ->where(['userid' => $user_id])
        ->andWhere(['>', 'balance', 0])
        ->orderBy('id desc')
        ->one();
        $coin_pay = 0.00;
        if (!empty($coin) && $coin->balance > 0 && $use_coin) {
            if (($coupon_pay + $coin->balance) >= $orderInfo->order_amount) {
                //此订单所花费钱包金额
                $coin_use = $orderInfo->order_amount - $coupon_pay;
                $coin_model = new Coin();
                $coin_model->userid = $user_id;
                $coin_model->income = -$coin_use;
                $coin_model->balance = $coin->balance - $coin_use;
                $coin_model->operation_detail = "购买课程花费$coin_use元";
                $coin_model->operation_time = time();
                $coin_model->card_id = $orderInfo->order_sn;
                $coin_model->save(false);
                
                //标记优惠券已使用
                $coupon->isuse = 2;
                $coupon->save(false);
                $order_info->pay_name = '优惠券+钱包支付';
                $orderInfo->coupon_ids = $coupon_id;
                $orderInfo->coupon_money = $coupon->fee;
                $orderInfo->bonus = $coin_use;
                $orderInfo->bonus_id = $coin_model->id;
                $orderInfo->pay_status = 2;
                $orderInfo->pay_time = time();
                $order_info->save(false);
                OrderGoods::updateAll(['pay_status' => 2], ['order_sn' => $order_sn]);
                
                //给邀请人发送奖励金额
                //查看此人是否是被邀请注册的
                $invite_peaple = User::find()
                ->where(['id' => $user_id])
                ->one();
                $invite = $invite_peaple->invite;
                //查看是否是第一次购买
                $is_first_order = OrderInfo::find()
                ->andWhere(['user_id' => $user_id])
                ->andWhere(['pay_status' => 2])
                ->count();
                if ($invite > 0 && $is_first_order == 0) {
                    $perc = Lookup::find()
                    ->where(['type' => 'share_course_shoping_get'])
                    ->one();
                    // 收入
                    $income = ($perc->code / 100.00) * $order_info->goods_amount;
                    //分享人报酬
                    $invite_pay = new Coin();
                    $invite_pay->userid = $invite;
                    $invite_pay->income = $income;
                    $invite_pay->balance = $income;
                    $invite_pay->operation_detail = '邀请注册首单奖励，邀请的用户： ' . $invite_peaple->username;
                    $invite_pay->operation_time = time();
                    $invite_pay->card_id = $order_info->order_sn;
                    $invite_pay->save(false);
                }
                
                $data = [
                    'code' => 1,
                    'wxpay' => 0,
                    'message' => '支付成功'
                ];
                return $data;
            
            } else {
                $coin_pay = $coin->balance;
            }
        }
        //微信支付需要支付的金额
        $weixin_pay = number_format($orderInfo->order_amount - $coupon_pay - $coin_pay, 2);
        //调用小程序登录API()
        $url = sprintf(Yii::$app->params['wxpay']['jscode2session_url'], $code);
        $response_str = ApiController::http_get_data($url);
        $response = json_decode($response_str);
        if (isset($response->errcode)) {
            $data = [
                'code' => -1,
                'message' => $response->errmsg
            ];
            return $data;
        }
        //统一下单
        $wxpay = new \WxPayApi();
        $attach = [
            'order_sn' => $orderInfo->order_sn,
        ];
        if (!empty($coupon)) {
            $attach['coupon_id'] = $coupon->coupon_id;
        }
        if ($use_coin) {
            $attach['coin_pay'] = $coin_pay;
        }
        $input = new \WxPayUnifiedOrder();
        $input->SetBody(trim('课程购买订单：'.$order_sn));
        $input->SetAttach(json_encode($attach));
        $input->SetOut_trade_no($order_sn);
        $input->SetTotal_fee($weixin_pay * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        //             $input->SetGoods_tag("test");
        //获取配置信息
        $config = Yii::$app->params['wxpay'];
        $input->SetNotify_url($config['notify_url']);
        $input->SetTrade_type("JSAPI");
        $input->SetProduct_id($orderInfo->order_sn);
        $input->SetOpenid($response->openid);
        $result = $wxpay->unifiedOrder($input);
        if ($result['return_code'] != 'SUCCESS') {
            $err_str = json_encode($result);
            $err_str .= 'file: '.__FILE__ . ' line: '.__LINE__;
            error_log($err_str);
        }
        $timeStamp = time();
        $pre_paySign = "appId=".$result['appid']."&nonceStr=".$result['nonce_str'];
        $pre_paySign .= "&package=prepay_id=".$result['prepay_id'].'&signType=MD5';
        $pre_paySign .= "&timeStamp=".$timeStamp."&key=".\WxPayConfig::KEY;
        $paySign = MD5($pre_paySign);
        $wxpaydata =[
            'appId' => $result['appid'],
            'timeStamp' => (string)$timeStamp,
            'nonceStr' => $result['nonce_str'],
            'package' => 'prepay_id='.$result['prepay_id'],
            'signType' => 'MD5',
            'paySign' => $paySign
        ];
        $data = [
            'code' => 2,
            'wxpay' => 1,
            'wxpaydata' => $wxpaydata
        ];
        return $data;
    
    }
    
//模式二
    /**
     * 流程：
     * 1、调用统一下单，取得code_url，生成二维码
     * 2、用户扫描二维码，进行支付
     * 3、支付完成之后，微信服务器会通知支付成功
     * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
     */
    public function actionWxpay()
    {
        $get = Yii::$app->request->get();
        $order_sn = $get['order_sn'];
        $access_token = $get['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $user_id = $user->id;
        
        $orderInfo = OrderInfo::find()
        ->where(['order_sn' => $order_sn])
        ->andWhere(['user_id' => $user_id])
        ->andWhere(['pay_status' => 0])
        ->one();
        if (!empty($orderInfo)) {
            $notify = new \NativePay();
            $url1 = $notify->GetPrePayUrl($order_sn);
            
            $input = new \WxPayUnifiedOrder();
            $input->SetBody(trim('课程购买订单：'.$orderInfo->order_sn));
            $input->SetAttach($orderInfo->order_sn);
            $input->SetOut_trade_no($orderInfo->order_sn);
            $input->SetTotal_fee($orderInfo->order_amount * 100);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            //获取配置信息
            $config = Yii::$app->params['wxpay'];
            $input->SetNotify_url($config['notify_url']);
            $input->SetTrade_type("JSAPI");
            $input->SetProduct_id($orderInfo->order_sn);
            $result = $notify->GetPayUrl($input);
            if ($result['return_code'] == 'SUCCESS') {
                if ($result['result_code'] == 'SUCCESS') {
                    $url2 = self::qrcode($result["code_url"], 'wxpay.png');
                    return $this->render('wxpay', ['code_url' => $url2, 'out_trade_no' => $orderInfo->order_sn]);
                } else {
                    $return_msg = $result['err_code'] . ':' . $result['err_code_des'];
                    error_log($return_msg);
                    return $this->render('wxpay', ['return_msg' => $return_msg]);
                }
            } else {
                $return_msg = $result['result_code'].':'.$result['return_msg'];
                error_log($return_msg);
                return $this->render('wxpay', ['return_msg' => $return_msg]);
            }
        }
    }
    
    public function actionWxcheckorder()
    {
        $data = Yii::$app->request->get();
        
        if(!empty($data["out_trade_no"])){
            $out_trade_no = $data["out_trade_no"];
            $input = new \WxPayOrderQuery();
            $input->SetOut_trade_no($out_trade_no);
            $result = \WxPayApi::orderQuery($input);
            if(array_key_exists("return_code", $result)
                && array_key_exists("result_code", $result)
                && $result["return_code"] == "SUCCESS"
                && $result["result_code"] == "SUCCESS")
            {
                //商户订单号
                $out_trade_no = $result['out_trade_no'];
                $order_info = OrderInfo::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['order_status' => 1])
                ->andWhere(['pay_status' => 0])
                ->one();
                if ($result['trade_state'] == "SUCCESS") {
    
                    //微信支付订单号
                    $transaction_id = $result['transaction_id'];
                    //支付金额(单位：分)
                    $total_fee = $result['total_fee']/100.00;
                    //支付完成时间
                    $time_end = $result['time_end'];
                    $wxpay = $order_info->order_amount;
                    if (isset($result['attach']) && !empty($result['attach'])) {
                        $attach = json_decode($result['attach'], true);
                        if (isset($attach['coupon_id'])) {
                            $coupon = Coupon::findOne(['user_id' => $order_info->user_id, 'coupon_id' => $attach['coupon_id']]);
                            $wxpay -= $coupon->fee;
                        }
                        if (isset($attach['coin_pay'])) {
                            $wxpay -= $attach['coin_pay'];
                        }
                    }
                    $wxpay = number_format($wxpay, 2);
    
                    if (!empty($order_info)) {
                        if ($wxpay == $total_fee) {
                            // attach
                            if (isset($result['attach']) && !empty($result['attach'])) {
                                
                                $attach = json_decode($result['attach'], true);
                                if (isset($attach['coupon_id'])) {
                                    $coupon = Coupon::findOne(['user_id' => $order_info->user_id, 'coupon_id' => $attach['coupon_id']]);
                                    $coupon->isuse = 2;
                                    $coupon->update();
                                    $order_info->coupon_ids = $attach['coupon_id'];
                                    $order_info->coupon_money = $coupon->fee;
                                }
                                if (isset($attach['coin_pay'])) {
                                    $coin = Coin::find()
                                    ->where(['userid' => $order_info->user_id])
                                    ->andWhere(['>', 'balance', 0])
                                    ->orderBy('id desc')
                                    ->one();
                                    $coin_model = new Coin();
                                    $coin_model->userid = $order_info->user_id;
                                    $coin_model->income = -$attach['coin_pay'];
                                    $coin_model->balance = $coin->balance - $attach['coin_pay'];
                                    $coin_model->operation_detail = "购买课程花费".$attach['coin_pay']."元";
                                    $coin_model->operation_time = time();
                                    $coin_model->card_id = $order_info->order_sn;
                                    $coin_model->save(false);
                                    $order_info->bonus = $attach['coin_pay'];
                                    $order_info->bonus_id = $coin_model->id;
                                }
    
    
                            }
                            //给邀请人发送奖励金额
                            //查看此人是否是被邀请注册的
                            $invite_peaple = User::find()
                            ->where(['id' => $order_info->user_id])
                            ->one();
                            $invite = $invite_peaple->invite;
                            //查看是否是第一次购买
                            $is_first_order = OrderInfo::find()
                            ->andWhere(['user_id' => Yii::$app->user->id])
                            ->andWhere(['pay_status' => 2])
                            ->count();
                            if ($invite > 0 && $is_first_order == 0) {
                                $perc = Lookup::find()
                                ->where(['type' => 'share_course_shoping_get'])
                                ->one();
                                // 收入
                                $income = ($perc->code / 100.00) * $order_info->goods_amount;
                                //分享人报酬
                                $invite_pay = new Coin();
                                $invite_pay->userid = $invite;
                                $invite_pay->income = $income;
                                $invite_pay->balance = $income;
                                $invite_pay->operation_detail = '邀请注册首单奖励，邀请的用户： ' . $invite_peaple->username;
                                $invite_pay->operation_time = time();
                                $invite_pay->card_id = $order_info->order_sn;
                                $invite_pay->save(false);
                            }
    
                            OrderGoods::updateAll(['pay_status' => 2], ['order_sn' => $out_trade_no]);
                            $order_info->pay_id = $transaction_id;
                            $order_info->pay_name = '微信支付';
                            $order_info->money_paid = $total_fee;
                            $order_info->pay_status = 2;
                            $order_info->pay_time = time();
                            $order_info->save(false);
                            //标记优惠券已使用
                            Coupon::updateAll(
                                ['isuse' => 2],
                                [
                                    'user_id' => $order_info->user_id,
                                    'coupon_id' => explode(',', $order_info->coupon_ids),
                                ]
                                );
                        }
                    }
                } else if ($result['trade_state'] == "PAYERROR") {
                    //支付失败，取消订单
                    $order_info->pay_id = $transaction_id;
                    $order_info->pay_name = '微信支付';
                    $order_info->order_status = 2;
                    $order_info->pay_status = 0;
                    $order_info->invalid_time = time();
                    $order_info->save(false);
                    //返回优惠券
                    Coupon::updateAll(
                        ['isuse' => 0],
                        [
                            'user_id' => $order_info->user_id,
                            'coupon_id' => explode(',', $order_info->coupon_ids),
                        ]
                        );
                }
            }
    
            return json_encode($result);
        }
    }

    public function actionBookOrder()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $book_id = $data['book_id'];
        $username = $data['username'];
        $phone = $data['phone'];
        $addres = $data['address'];

        $user = User::findIdentityByAccessToken($access_token);
        if (empty($user)) {
            $result = [
                'status' => -1,
                'message' => '未找到用户，请尝试重新登录！'
            ];
            return $result;
        }
        foreach ($book_id as $id) {
            $book_name = Book::find()->select('name')->where(['id' => $id])->one();
            $book_order = new BookOrder();
            $book_order->bookid = $id;
            $book_order->userid = $user->id;
            $book_order->book_num = 1;
            $book_order->book_name = $book_name->name;
            $book_order->username = $username;
            $book_order->phone = $phone;
            $book_order->address = $addres;
            $book_order->order_time = time();
            $book_order->save();
        }
        $data = [
            'code' => 0,
            'message' => '选择教材成功',
        ];
        return $data;

    }
    
    public static function createOrderid()
    {
        //生成24位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-CC，其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数，CC=检查码
        //订购日期
        $order_date = date('Y-m-d');
        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
        $order_id_main = date('YmdHis') . rand(10000000,99999999);
        //订单号码主体长度
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for($i=0; $i<$order_id_len; $i++){
            $order_id_sum += (int)(substr($order_id_main,$i,1));
        }
        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
        $order_sn = 'KB-' . $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);
        return $order_sn;
    }
}
