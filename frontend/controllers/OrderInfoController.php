<?php

namespace frontend\controllers;
use Yii;
use backend\models\Coupon;
use backend\models\Course;
use backend\models\OrderInfo;
use backend\models\OrderGoods;
use backend\models\CoursePackage;
use backend\models\Cart;
require "../../common/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php";
require "../../common/alipay/pagepay/service/AlipayTradeService.php";

class OrderInfoController extends \yii\web\Controller
{
    public function actionSlcourse()
    {
        return $this->render('slcourse');
    }

    public function actionCart()
    {
        return $this->render('cart');
    }

    public function actionConfirm_order()
    {
        //唯一订单号码（KB-YYYYMMDDHHIISSNNNNNNNNCC）
        $order_sn = $this->createOrderid();
        $data = Yii::$app->request->Post();
        
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
        //添加订单商品
        foreach($course_models as $model) {
            $order_goods = new OrderGoods();
            $order_goods->order_sn = $order_sn;
            $order_goods->goods_id = $model->id;
            $order_goods->goods_name = $model->course_name;
            $order_goods->goods_number = 1;
            $order_goods->market_price = $model->price;
            $order_goods->goods_price = $model->discount;
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
        //添加订单商品
        foreach($course_package_models as $model) {
            $order_goods = new OrderGoods();
            $order_goods->order_sn = $order_sn;
            $order_goods->goods_id = $model->id;
            $order_goods->goods_name = $model->name;
            $order_goods->goods_number = 1;
            $order_goods->market_price = $model->price;
            $order_goods->goods_price = $model->discount;
            $order_goods->save(false);
            $goods_amount += $model->discount;
        }
        
        $course_ids_arr = explode(',', $courseids);
        $course_ids_str = implode(',', array_unique($course_ids_arr));
        $order_amount = $goods_amount - $coupon_money;
        
        $order_info = new OrderInfo();
        $order_info->order_sn = $order_sn;
        $order_info->user_id = Yii::$app->user->id;
        $order_info->order_status = 1;
        $order_info->pay_status = 0;
        $order_info->consignee = Yii::$app->user->identity->username;
        $order_info->mobile = Yii::$app->user->identity->phone;
        $order_info->email = Yii::$app->user->identity->email;
        //0 1支付宝 2 微信
        $order_info->pay_id = 0;
        $order_info->goods_amount = $goods_amount;
        $order_info->order_amount = $order_amount;
        $order_info->coupon_ids = $coupon_ids_str;
        $order_info->coupon_money = $coupon_money;
        $order_info->course_ids = $course_ids_str;
        $order_info->save(false);
        return $this->render('payok', ['order_sn' => $order_sn, 'order_amount' => $order_amount]);
    }
    
    public function actionPay()
    {
        
        $_POST['WIDout_trade_no'] = '123';
        $_POST['WIDsubject'] = 'wuli';
        $_POST['WIDtotal_amount'] = '0.01';
        $_POST['WIDbody'] = 'wuli';
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($_POST['WIDout_trade_no']);
        
        //订单名称，必填
        $subject = trim($_POST['WIDsubject']);
        
        //付款金额，必填
        $total_amount = trim($_POST['WIDtotal_amount']);
        
        //商品描述，可空
        $body = trim($_POST['WIDbody']);
        
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
    }

    public function actionPayway()
    {
        return $this->render('payway');
    }
    
    private function createOrderid()
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
