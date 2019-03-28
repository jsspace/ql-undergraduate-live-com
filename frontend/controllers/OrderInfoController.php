<?php

namespace frontend\controllers;
use backend\models\GoldOrderInfo;
use backend\models\Message;
use backend\models\Read;
use common\service\GoldService;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Coupon;
use backend\models\Course;
use backend\models\OrderInfo;
use backend\models\OrderGoods;
use backend\models\CoursePackage;
use backend\models\Cart;
use backend\models\Coin;
use Da\QrCode\QrCode;
use yii\base\InvalidValueException;
use backend\models\Lookup;
use backend\models\User;

require_once "../../common/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php";
require_once "../../common/alipay/pagepay/service/AlipayTradeService.php";

require_once "../../common/wxpay/lib/WxPay.Api.php";
require_once "../../common/wxpay/example/WxPay.NativePay.php";
require_once '../../common/wxpay/example/log.php';


class OrderInfoController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['confirm_order', 'alipay', 'wxpay'],
                'rules' => [
                    [
                        'actions' => ['confirm_order', 'alipay', 'wxpay'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'confirm_order' => ['post','get'],
                    'alinotify' => ['post'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        $currentaction = $action->id;
        $novalidactions = ['alinotify', 'wxnotify'];
        if(in_array($currentaction,$novalidactions)) {
            $action->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionConfirm_order($order_sn)
    {
        $orderInfo = OrderInfo::find()
        ->where(['order_sn' => $order_sn])
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 0])
        ->one();
        if (!empty($orderInfo)) {
            return $this->render('payok', ['order_sn' => $order_sn, 'order_amount' => $orderInfo->order_amount]);
        }
        $data = Yii::$app->request->Post();
        // if (!isset($data['coupon_ids']) || !isset($data['course_ids']) || !isset($data['course_package_ids'])) {
        if (!isset($data['course_ids']) && !isset($data['course_package_ids'])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if (empty($data['course_ids']) && empty($data['course_package_ids'])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $goods_amount = 0.00;
        /* $coupon_ids = explode(',', $data['coupon_ids']);
        $coupon_money = 0.00;
        $coupons = Coupon::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['coupon_id' => $coupon_ids])
        ->andWhere(['isuse' => 0])
        ->andWhere(['>', 'end_time', date('Y-m-d H:i:s', time())])
        ->all();
        $coupon_ids_str = '';
        foreach($coupons as $model) {
            $coupon_ids_str .= $model->coupon_id . ',';
            $coupon_money += $model->fee;
            //标记优惠券正在使用中
            $model->isuse = 1;
            $model->save(false);
        }
        */
        $course_ids = explode(',', $data['course_ids']);
        //删除购物车中对应的条目
        Cart::deleteAll([
            'product_id' => $course_ids, 
            'user_id' => Yii::$app->user->id,
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
            $order_goods->user_id = Yii::$app->user->id;
            $order_goods->type = 'course';
            $order_goods->save(false);
            $goods_amount += $model->discount;
        }
        $course_package_ids = explode(',', $data['course_package_ids']);
        //删除购物车中对应的条目
        Cart::deleteAll([
            'product_id' => $course_package_ids,
            'user_id' => Yii::$app->user->id,
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
            $order_goods->user_id = Yii::$app->user->id;
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
        // $invite = Yii::$app->user->identity->invite;
        //查看是否是第一次购买
        /*$order_count = OrderInfo::find()
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 2])
        ->count();
        if ($invite > 0 && $order_count == 0) {
            //被邀请会员第一次购买有优惠
            $perc = Lookup::find()
            ->where(['type' => 'share_course_discount'])
            ->one();
            $order_amount = ((100 - $perc->code) / 100.00) * $goods_amount - $coupon_money;
        } else {
            $order_amount = $goods_amount - $coupon_money;
        }
        if ($goods_amount < $coupon_money) {
            $order_amount = 0;
        } else {
            $order_amount = $goods_amount - $coupon_money;
        }*/
        $order_amount = $goods_amount;
        //添加订单信息
        $order_info = new OrderInfo();
        $order_info->order_sn = $order_sn;
        $order_info->user_id = Yii::$app->user->id;
        $order_info->order_status = 1;
        //$order_info->pay_status = 0;
        $order_info->consignee = Yii::$app->user->identity->username;
        $order_info->mobile = Yii::$app->user->identity->phone;
        $order_info->email = Yii::$app->user->identity->email;
        //0 1支付宝 2 微信
        $order_info->pay_id = 0;
        $order_info->goods_amount = $goods_amount;
        $order_info->order_amount = $order_amount;
        $order_info->add_time = time();
        $order_info->course_ids = $course_ids_str;
        $gift_books = explode(",",$data['gift_books']);
        $gift_books = array_filter($gift_books);
        $order_info->gift_books = implode(',', $gift_books);
        $order_info->gift_coins = $data['gift_coins'];
        // 购买课程
//        $gold_service = new GoldService();
//        $gold_service->changeUserGold($data['gift_coins'], Yii::$app->user->id, 6);

        // $order_info->coupon_ids = $coupon_ids_str;
        // $order_info->coupon_money = $coupon_money;
        // $order_info->invalid_time = time() + 3600 * 24 * 180;
         $order_info->invalid_time = strtotime('2020-3-20');
        /*$order_info->bonus = $bonus;*/
        if ($order_amount == 0) {
            $order_info->pay_status = 2;
        } else {
            $order_info->pay_status = 0;
        }
        $order_info->save(false);
        if ($order_amount == 0) {
            return $this->redirect('/user/orders');
        } else {
            return $this->render('payok', ['order_sn' => $order_sn, 'order_amount' => $order_amount]);
        }
    }

    public function actionGold_confirm_order($order_sn)
    {

        $orderInfo = GoldOrderInfo::find()
            ->where(['order_sn' => $order_sn])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['pay_status' => 0])
            ->one();
        if (!empty($orderInfo)) {
            return $this->render('gold_payok', ['order_sn' => $order_sn, 'gold_num' => $orderInfo->gold_num, 'money_paid'=>$orderInfo->money_paid]);
        }
        $data = Yii::$app->request->Post();

        //添加订单信息
        $order_info = new GoldOrderInfo();
        $order_info->order_sn = $order_sn;
        $order_info->user_id = Yii::$app->user->id;
        $order_info->order_status = 1;
        $order_info->pay_status = 0;

        $need_money = (int)$data['money'];
        $gold_num = (int)$data['gold_num'];
        //$need_money = 0.1; //测试使用
        // 需要再次校验金币是否与金额关系是否正确
        $order_info->money_paid= 0;
        $order_info->gold_num = $gold_num;
        $order_info->order_amount = $need_money;
        //0 1支付宝 2 微信
        $order_info->pay_id = 0;
        $order_info->add_time = time();
        $order_info->save(false);
         return $this->render('gold_payok', ['order_sn' => $order_sn, 'money_paid'=>$need_money]);
    }

    /**
     * 金币购买--支付宝呼起支付
     * @param $order_sn
     * @throws NotFoundHttpException
     */
    public function actionGold_alipay($order_sn)
    {
        $orderInfo = GoldOrderInfo::find()
            ->where(['order_sn' => $order_sn])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['pay_status' => 0])
            ->one();
        if (!empty($orderInfo)) {

            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = trim($orderInfo->order_sn);

            //订单名称，必填
            $subject = trim('金币买订单：'.$orderInfo->order_sn);

            //付款金额，必填
            $total_amount = trim($orderInfo->order_amount);

            //商品描述，可空
            $body = 'gold_num:'.$orderInfo->gold_num;
            $body = trim($body);

            //构造参数
            $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setOutTradeNo($out_trade_no);

            //获取配置信息
            $config = Yii::$app->params['alipay'];
            $aop = new \AlipayTradeService($config);

            /**
             * pagePay 电脑网站支付请求
             * @param $builder 业务参数，使用buildmodel中的对象生成。
             * @param $return_url 同步跳转地址，公网可以访问
             * @param $notify_url 异步通知地址，公网可以访问
             * @return $response 支付宝返回的信息
             */
            $response = $aop->pagePay($payRequestBuilder,$config['gold_return_url'],$config['gold_notify_url']);

            //输出表单
            var_dump($response);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    
    public function actionAlipay($order_sn)
    {
        $orderInfo = OrderInfo::find()
        ->where(['order_sn' => $order_sn])
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 0])
        ->one();
        if (!empty($orderInfo)) {
            
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = trim($orderInfo->order_sn);
            
            //订单名称，必填
            $subject = trim('课程购买订单：'.$orderInfo->order_sn);
            
            //付款金额，必填
            $total_amount = trim($orderInfo->order_amount);
            
            //商品描述，可空
            $body = 'course_ids:'.$orderInfo->course_ids;
            $body .= ' course_package_ids:'.$orderInfo->course_ids;
            $body = trim($body);
            
            //构造参数
            $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setOutTradeNo($out_trade_no);


            //获取配置信息
            $config = Yii::$app->params['alipay'];
            $aop = new \AlipayTradeService($config);
            
            /**
             * pagePay 电脑网站支付请求
             * @param $builder 业务参数，使用buildmodel中的对象生成。
             * @param $return_url 同步跳转地址，公网可以访问
             * @param $notify_url 异步通知地址，公网可以访问
             * @return $response 支付宝返回的信息
             */
            $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
            
            //输出表单
            var_dump($response);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionGold_wxpay($order_sn)
    {
        $orderInfo = GoldOrderInfo::find()
            ->where(['order_sn' => $order_sn])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['pay_status' => 0])
            ->one();
        if (!empty($orderInfo)) {
            $notify = new \NativePay();
            $url1 = $notify->GetPrePayUrl($order_sn);
            $input = new \WxPayUnifiedOrder();
            $input->SetBody(trim('金币购买订单：'.$orderInfo->order_sn));
            $input->SetAttach($orderInfo->order_sn);
            $input->SetOut_trade_no($orderInfo->order_sn);
            $total_fee = number_format($orderInfo->order_amount, 2) * 100;
            $input->SetTotal_fee($total_fee);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            //获取配置信息
            $config = Yii::$app->params['wxpay'];
            $input->SetNotify_url($config['gold_notify_url']);
            $input->SetTrade_type("NATIVE");
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


    
    public function actionAlinotify()
    {
        $data = Yii::$app->request->Post();
        $arr=$data;
        //获取配置信息
        $config = Yii::$app->params['alipay'];
        $alipaySevice = new \AlipayTradeService($config);
        $alipaySevice->writeLog(var_export($data,true));
        $result = $alipaySevice->check($arr);
        
        /* 实际验证过程建议商户添加以下校验。
         1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
         2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
         3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
         4、验证app_id是否为该商户本身。
         */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代
        
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            //商户订单号
            $out_trade_no = $data['out_trade_no'];
            //支付宝交易号
            $trade_no = $data['trade_no'];
            //交易状态
            $trade_status = $data['trade_status'];
            //支付金额
            $total_amount = $data['total_amount'];
            //支付宝交易号
            $trade_no = $data['trade_no'];
        
            if ($data['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                $order_info = OrderInfo::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['order_status' => 1])
                ->one();
                if (!empty($order_info) && $order_info->order_amount == $total_amount) {
                    if ($order_info->pay_status == 0) {
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
                        $order_info->pay_id = $trade_no;
                        $order_info->pay_name = '支付宝支付';
                        $order_info->money_paid = $total_amount;
                        $order_info->pay_status = 2;
                        $order_info->pay_time = time();
                        $order_info->save(false);

                        $message = new Message();
                        $message->publisher = 1;
                        $message->content = '测试消息！';
                        $message->classids = 'alluser';
                        $message->title = '测试消息@2！';
                        $message->status = 1;
                        $message->publish_time = time();
                        $message->save();

                        // 给邀请人以及授课教师发送消息
//                        if ($invite > 0) {
//                            $goods = OrderGoods::find()->where(['order_sn' => $out_trade_no])->one();
//                            if (!empty($goods)) {
//                                $user_ids = '';
//                                if ($goods->type == 'course') {     // 查找课程的教师
//                                    $course = Course::find()->where(['id' => $goods->goods_id])->one();
//                                    $user_ids = $course->teacher_id;
//
//                                } else {    // 依次读取套餐中各门课程的教师
//                                    $package = CoursePackage::find()->where(['id' => $goods->goods_id])->one();
//                                    $courses = explode(',', $package->course);
//                                    $courses = array_filter($courses);
//                                    foreach ($courses as $cours) {
//                                        $cour = Course::find()->where(['id' => $cours])->one();
//                                        $user_ids = $user_ids . ',' .$cour->teacher_id;
//                                    }
//                                }
//                                $message = new Message();
//                                $message->publisher = 1;
//                                $message->title = '系统消息：有人下单啦！';
//                                $message->classids = $user_ids;
//                                $message->content = "尊敬的老师、市场专员您好！ 您有学生（被邀请人）". time() ."在平台下单啦!  购买了"
//                                    . $goods->goods_name . ", 总金额为：" . $goods->goods_price . "(元), 您将按照比例获得提成！";
//                                $message->status = 1;
//                                $message->publish_time = time();
//                                $message->save();
//
//                                foreach ($user_ids as $user_id) {
//                                    $read = new Read();
//                                    $read->msg_id = $message->msg_id;
//                                    $read->userid = $user_id;
//                                    $read->status = 0;
//                                    $read->get_time = time();
//                                    $read->save();
//                                }
//                            }
//                        }

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
                //金币的回调处理
                $gold_order_info = GoldOrderInfo::find()
                    ->where(['order_sn' => $out_trade_no])
                    ->andWhere(['order_status' => 1])
                    ->one();
                if (!empty($gold_order_info) && $gold_order_info->order_amount == $total_amount) {
                    if ($gold_order_info->pay_status == 0) {
                        //给邀请人发送奖励金额
                        $gold_order_info->pay_id = $trade_no;
                        $gold_order_info->pay_name = '支付宝支付';
                        $gold_order_info->money_paid = $total_amount;
                        //再次计算金币的数量
                        $gold_num = $total_amount * 10;
                        $gold_order_info->gold_num = $gold_num;
                        $gold_order_info->pay_status = 2;
                        $gold_order_info->pay_time = time();
                        $gold_order_info->save(false);
                        // 赠送金币
                        $goldService = new GoldService();
                        $goldService->changeUserGold($gold_num, $gold_order_info->user_id, '1');
                    }
                }


            } else if ($data['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                $order_info = OrderInfo::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['pay_status' => 0])
                ->andWhere(['order_status' => 1])
                ->one();
                if (!empty($order_info) && $order_info->order_amount == $total_amount) {
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
                    $order_info->pay_id = $trade_no;
                    $order_info->pay_name = '支付宝支付';
                    $order_info->money_paid = $total_amount;
                    $order_info->pay_status = 2;
                    $order_info->pay_time = time();
                    $order_info->save(false);

                    $message = new Message();
                    $message->publisher = 1;
                    $message->content = '测试消息222！';
                    $message->classids = 'alluser';
                    $message->status = 1;
                    $message->title = '测试消息1';
                    $message->publish_time = time();
                    $message->save();

                    // 给邀请人以及授课教师发送消息
//                    if ($invite > 0) {
//                        $goods = OrderGoods::find()->where(['order_sn' => $order_info->order_sn])->one();
//                        if (!empty($goods)) {
//                            $user_ids = '';
//                            if ($goods->type == 'course') {     // 查找课程的教师
//                                $course = Course::find()->where(['id' => $goods->goods_id])->one();
//                                $user_ids = $course->teacher_id;
//                            } else {    // 依次读取套餐中各门课程的教师
//                                $package = CoursePackage::find()->where(['id' => $goods->goods_id])->one();
//                                $courses = explode(',', $package->course);
//                                $courses = array_filter($courses);
//                                foreach ($courses as $cours) {
//                                    $cour = Course::find()->where(['id' => $cours])->one();
//                                    $user_ids = $user_ids . ',' .$cour->teacher_id;
//                                }
//                            }
//                            $message = new Message();
//                            $message->publisher = 1;
//                            $message->title = '系统消息：有人下单啦！';
//                            $message->classids = $user_ids;
//                            $message->content = "尊敬的老师、市场专员您好！ 您有学生（被邀请人）". time() ."在平台下单啦!  购买了"
//                                . $goods->goods_name . ", 总金额为：" . $goods->goods_price . "(元), 您将按照比例获得提成！";
//                            $message->status = 1;
//                            $message->publish_time = time();
//                            $message->save();
//
//                            foreach ($user_ids as $user_id) {
//                                $read = new Read();
//                                $read->msg_id = $message->msg_id;
//                                $read->userid = $user_id;
//                                $read->status = 0;
//                                $read->get_time = time();
//                                $read->save();
//                            }
//                        }
//                    }

                    //标记优惠券已使用
                    Coupon::updateAll(
                        ['isuse' => 2],
                        [
                            'user_id' => $order_info->user_id,
                            'coupon_id' => explode(',', $order_info->coupon_ids),
                        ]
                        );
                }

                $gold_order_info = GoldOrderInfo::find()
                    ->where(['order_sn' => $out_trade_no])
                    ->andWhere(['pay_status' => 0])
                    ->andWhere(['order_status' => 1])
                    ->one();
                if (!empty($gold_order_info) && $gold_order_info->order_amount == $total_amount) {

                    $gold_order_info->pay_id = $trade_no;
                    $gold_order_info->pay_name = '支付宝支付';
                    $gold_order_info->money_paid = $total_amount;
                    //再次计算金币的数量
                    $gold_num = $total_amount * 10;
                    $gold_order_info->gold_num = $gold_num;
                    $gold_order_info->pay_status = 2;
                    $gold_order_info->pay_time = time();
                    $gold_order_info->save(false);
                    // 赠送金币
                    $goldService = new GoldService();
                    $goldService->changeUserGold($gold_num, $gold_order_info->user_id, '1');

                }
                
            } else if ($data['trade_status'] == 'TRADE_CLOSED') {
                $order_info = OrderInfo::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['order_status' => 1])
                ->one();
                if (!empty($order_info) && $order_info->order_amount == $total_amount) {
                    //取消订单
                    $order_info->pay_id = $trade_no;
                    $order_info->pay_name = '支付宝支付';
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

                $gold_order_info = GoldOrderInfo::find()
                    ->where(['order_sn' => $out_trade_no])
                    ->andWhere(['order_status' => 1])
                    ->one();
                if (!empty($gold_order_info) && $gold_order_info->order_amount == $total_amount) {
                    //取消订单
                    $gold_order_info->pay_id = $trade_no;
                    $gold_order_info->pay_name = '支付宝支付';
                    $gold_order_info->order_status = 2;
                    $gold_order_info->pay_status = 0;
                    $gold_order_info->invalid_time = time();
                    $gold_order_info->save(false);

                }
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";	//请不要修改或删除
        }else {
            echo "fail";
        }
        
    }
    
    //模式二
    /**
     * 流程：
     * 1、调用统一下单，取得code_url，生成二维码
     * 2、用户扫描二维码，进行支付
     * 3、支付完成之后，微信服务器会通知支付成功
     * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
     */
    public function actionWxpay($order_sn)
    {
        
        $orderInfo = OrderInfo::find()
        ->where(['order_sn' => $order_sn])
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 0])
        ->one();
        if (!empty($orderInfo)) {
            $notify = new \NativePay();
            $url1 = $notify->GetPrePayUrl($order_sn);
            
            $input = new \WxPayUnifiedOrder();
            $input->SetBody(trim('课程购买订单：'.$orderInfo->order_sn));
            $input->SetAttach($orderInfo->order_sn);
            $input->SetOut_trade_no($orderInfo->order_sn);
            $total_fee = number_format($orderInfo->order_amount, 2) * 100;
            $input->SetTotal_fee($total_fee);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
//             $input->SetGoods_tag("test");
            //获取配置信息
            $config = Yii::$app->params['wxpay'];
            $input->SetNotify_url($config['notify_url']);
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id($orderInfo->order_sn);
            $result = $notify->GetPayUrl($input);
//             print_r($result);die();
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
    
    public function actionWxnotify()
    {
        error_log('file:'.__FILE__.'  line:'.__LINE__);
        //获取通知的数据
        $xml = Yii::$app->request->getRawBody();
        error_log('file:'.__FILE__.'  line:'.__LINE__.'   xml:'.$xml);
        //如果返回成功则验证签名
        //try {
        $result = $this->fromXml($xml);
        if($result['return_code'] == 'SUCCESS')
        {
            $sign = $this->sign($result);
            if($sign == $result['sign'])
            {
                if ($result['result_code'] == 'SUCCESS') {
                    //商户订单号
                    $out_trade_no = $result['out_trade_no'];
                    //微信支付订单号
                    $transaction_id = $result['transaction_id'];
                    //交易类型
                    $trade_type = $result['trade_type'];
                    //支付金额(单位：分)
                    $total_fee = $result['total_fee']/100.00;
                    //支付完成时间
                    $time_end = $result['time_end'];
                
                
                    $order_info = OrderInfo::find()
                    ->where(['order_sn' => $out_trade_no])
                    ->andWhere(['order_status' => 1])
                    ->andWhere(['pay_status' => 0])
                    ->one();
                
                    if (!empty($order_info)) {
                        if ($order_info->order_amount == $total_fee) {
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
                    } else {
                        //订单状态已更新，直接返回
                        return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
                    }
                } else {
                    $return_msg = $result['err_code'].':'.$result['err_code_des'];
                    error_log($return_msg);
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
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
                //微信支付订单号
                $transaction_id = $result['transaction_id'];
                //商户订单号
                $out_trade_no = $result['out_trade_no'];
                $order_info = OrderInfo::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['order_status' => 1])
                ->andWhere(['pay_status' => 0])
                ->one();
                //如果此订单为空 // 查询金币订单
                $result['buy_gold'] = false;
                if(empty($order_info)){
                    $order_info = GoldOrderInfo::find()
                        ->where(['order_sn' => $out_trade_no])
                        ->andWhere(['order_status' => 1])
                        ->andWhere(['pay_status' => 0])
                        ->one();
                    // 处理金币订单信息
                    if(!empty($order_info)){
                        if ($result['trade_state'] == "SUCCESS") {
                            //微信支付订单号
                            $transaction_id = $result['transaction_id'];
                            //支付金额(单位：分)
                            $total_fee = $result['total_fee']/100.00;
                            //支付完成时间
                            $time_end = $result['time_end'];
                            $wxpay = $order_info->order_amount;
                            $wxpay = number_format($wxpay, 2);
                            if (!empty($order_info)) {
                                if ($wxpay == $total_fee) {
                                    $order_info->pay_id = $transaction_id;
                                    $order_info->pay_name = '微信支付';
                                    $order_info->money_paid = intval($total_fee);
                                    //再次计算金币的数量
                                    $gold_num = intval($total_fee * 10);
                                    $order_info->gold_num = $gold_num;
                                    $order_info->pay_status = 2;
                                    $order_info->pay_time = time();
                                    $order_info->save(false);
                                    //赠送金币
                                    $goldService = new GoldService();
                                    $goldService->changeUserGold($gold_num, $order_info->user_id, '1');
                                    $result['buy_gold'] = true;
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
                        }
                    }
                }else {
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

            }

            return json_encode($result);
        }
     }
     
     private function toXml($values)
     {
         if(!is_array($values) || count($values) <= 0)
         {
             throw new InvalidValueException("数组数据异常！");
         }
         //var_dump($values);exit;
         $xml = "<xml>";
         foreach ($values as $key=>$val)
         {
             if (is_numeric($val)){
                 $xml.="<".$key.">".$val."</".$key.">";
             }else{
                 $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
     
             }
         }
         $xml.="</xml>";
         //echo $xml;exit;
         return $xml;
     }
     
     private function fromXml($xml)
     {
         if(!$xml){
             throw new InvalidValueException("xml数据异常！");
         }
         try
         {
             $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
         }
         catch(\Exception $e)
         {
             throw new InvalidValueException("xml数据异常！");
         }
         return $values;
     }
     
     public function sign($values)
     {
         ksort($values);
         $string = "";
         foreach ($values as $k => $v)
         {
             if($k != "sign" && $v != "" && !is_array($v)){
                 $string .= $k . "=" . $v . "&";
             }
         }
     
         $string = trim($string, "&");
         $string = $string . "&key=".$this->key;
         $string = md5($string);
         return strtoupper($string);
     }
    
    public static function qrcode($url, $name)
    {
        $qrCode = (new QrCode($url))
        ->setSize(250)
        ->setMargin(5)
        ->useForegroundColor(51, 153, 255);
        return $qrCode->writeDataUri();
    }

}
