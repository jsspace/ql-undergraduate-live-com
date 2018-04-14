<?php

namespace api\controllers;

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

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class OrderController extends Controller
{
    /* 过滤器实现认证 */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticatior' => [
                'class' => QueryParamAuth::className()
            ]
        ]);
    }
    
    public function actionShopping()
    {
        $post = Yii::$app->request->Post();
        $getdata = Yii::$app->request->get();
        $access_token = $getdata['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $user_id = $user->id;
        
        //唯一订单号码（KB-YYYYMMDDHHIISSNNNNNNNNCC）
        $order_sn = $this->createOrderid();
        
        $course_package_ids = explode(',', $post['course_package_ids']);
        $course_ids = explode(',', $post['course_ids']);
        $course_array = Course::find()
        ->where(['id' => $course_ids])
        ->andWhere(['onuse' => 1])
        ->asArray()
        ->all();
        $course_ids = '';
        foreach($course_array as $course) {
            $course_ids .= $course['id'] . ',';
        }
        $course_package_array = CoursePackage::find()
        ->where(['id' => $course_package_ids])
        ->andWhere(['onuse' => 1])
        ->asArray()
        ->all();
        $course_package_ids = '';
        foreach($course_package_array as $course_package) {
            $course_package_ids .= $course_package['id'] . ',';
        }
        $coupons = Coupon::find()
        ->where(['user_id' => $user_id])
        ->andWhere(['isuse' => 0])
        ->andWhere(['>', 'end_time', date('Y-m-d H:i:s', time())])
        ->asArray()
        ->all();

        /*金币余额*/
        $coin = Coin::find()
        ->where(['userid' => $user_id])
        ->orderBy('id desc')
        ->asArray()
        ->one();
        if (!empty($coin)) {
            $balance = $coin['balance'];
        } else {
            $balance = 0;
        }
        $data = [
            'courses' => $course_array,
            'order_sn' => $order_sn,
            'course_ids' => $course_ids,
            'course_packages' => $course_package_array,
            'course_package_ids' => $course_package_ids,
            'coupons' => $coupons,
            'coin_balance' => $balance
        ];
        return json_encode($data);
    }
    public function actionConfirmOrder($userid, $courseid)
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
        ->where(['user_id' => Yii::$app->user->id])
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
        $invite = Yii::$app->user->identity->invite;
        //查看是否是第一次购买
        $is_first_order = OrderInfo::find()
        ->andWhere(['user_id' => Yii::$app->user->id])
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
            $coin->userid = Yii::$app->user->id;
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
        $order_info->user_id = Yii::$app->user->id;
        $order_info->order_status = 1;
        $order_info->pay_status = $pay_status;
        $order_info->consignee = Yii::$app->user->identity->username;
        $order_info->mobile = Yii::$app->user->identity->phone;
        $order_info->email = Yii::$app->user->identity->email;
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
    public function actionWxpay()
    {

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
