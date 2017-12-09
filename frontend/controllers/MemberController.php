<?php

namespace frontend\controllers;

use yii;
use backend\models\Member;
use backend\models\CourseCategory;
use backend\models\MemberOrder;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

require_once "../../common/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php";
require_once "../../common/alipay/pagepay/service/AlipayTradeService.php";

class MemberController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['pay'],
                'rules' => [
                    [
                        'actions' => ['pay'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'pay' => ['post'],
                    'alinotify' => ['post'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        $currentaction = $action->id;
        $novalidactions = ['alinotify'];
        if(in_array($currentaction,$novalidactions)) {
            $action->controller->enableCsrfValidation = false;
        }
        parent::beforeAction($action);
        return true;
    }
    
    public function actionIndex()
    {
        $member_items = [];
        $member_models = Member::find()
        ->orderBy('course_category_id asc,position asc')
        ->all();
        foreach ($member_models as $item) {
            $member_items[$item->course_category_id]['course_category'] = CourseCategory::item($item->course_category_id);
            $member_items[$item->course_category_id]['members'][] = $item;
        }
        return $this->render('index', ['member_items' => $member_items]);
    }
    
    public function actionPay()
    {
        $data = Yii::$app->request->post();
        $order_sn = CartController::createOrderid();
        $member_id = $data['member_id'];
        $memberInfo = Member::find()
        ->where(['id' => $member_id])
        ->one();
        
        if (!empty($memberInfo)) {
            //添加订单信息
            $order_info = new MemberOrder();
            $order_info->order_sn = $order_sn;
            $order_info->user_id = Yii::$app->user->id;
            $order_info->order_status = 1;
            $order_info->pay_status = 0;
            $order_info->consignee = Yii::$app->user->identity->username;
            $order_info->mobile = Yii::$app->user->identity->phone;
            $order_info->email = Yii::$app->user->identity->email;
            //0 1支付宝 2 微信
            $order_info->pay_id = 1;
            $order_info->pay_name = '支付宝';
            $order_info->goods_amount = $memberInfo->discount;
            $order_info->order_amount = $memberInfo->discount;
            $order_info->add_time = time();
            $order_info->end_time = time() + $memberInfo->time_period * 3600 * 24;
            $order_info->member_id = $memberInfo->id;
            $order_info->save(false);
            
            $orderInfo = [
                'order_sn' => CartController::createOrderid(),
                'user_id' => Yii::$app->user->id,
                'consignee' => Yii::$app->user->identity->username,
                'email' => Yii::$app->user->identity->email,
                'phone' => Yii::$app->user->identity->phone,
                'member_id' => $memberInfo->id,
                'order_name' => $memberInfo->name,
                'goods_amount' => $memberInfo->discount,
                'add_time' => time(),
                'end_time' => $memberInfo->time_period * 3600 * 24,
            ];
            
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = trim($orderInfo['order_sn']);
    
            //订单名称，必填
            $subject = trim($memberInfo->name);
    
            //付款金额，必填
            $total_amount = trim($memberInfo->discount);
    
            //商品描述，可空
            $body = json_encode($orderInfo);
    
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
            $response = $aop->pagePay($payRequestBuilder,Url::to(['user/orders'], true),Url::to(['member/alinotify'], true));
    
            //输出表单
            var_dump($response);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
    
            if ($data['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                $order_info = MemberOrder::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['order_status' => 1])
                ->one();
                if (!empty($order_info) && $order_info->order_amount == $total_amount) {
                    if ($order_info->pay_status == 0) {
                        $order_info->money_paid = $total_amount;
                        $order_info->pay_status = 2;
                        $order_info->pay_time = time();
                        $order_info->save(false);
                    }
                }
            } else if ($data['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                $order_info = MemberOrder::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['pay_status' => 0])
                ->andWhere(['order_status' => 1])
                ->one();
                print_r($order_info);
                if (!empty($order_info) && $order_info->order_amount == $total_amount) {
                    $order_info->money_paid = $total_amount;
                    $order_info->pay_status = 2;
                    $order_info->pay_time = time();
                    $order_info->save(false);
                }
    
            } else if ($data['trade_status'] == 'TRADE_CLOSED') {
                //未付款交易超时关闭，或支付完成后全额退款
                $order_info = MemberOrder::find()
                ->where(['order_sn' => $out_trade_no])
                ->andWhere(['order_status' => 1])
                ->one();
                if (!empty($order_info) && $order_info->order_amount == $total_amount) {
                    //未支付，取消订单
                    $order_info->order_status = 2;
                    $order_info->pay_status = 0;
                    $order_info->invalid_time = time();
                    $order_info->save(false);
                }
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";	//请不要修改或删除
        }else {
            echo "fail";
        }
    
    }
    
    public function actionRt()
    {
        $js = array (  'gmt_create' => '2017-12-09 16:03:31',  'charset' => 'UTF-8',  'gmt_payment' => '2017-12-09 16:03:45',  'notify_time' => '2017-12-09 16:03:45',  'subject' => '\xe4\xbc\x98\xe5\xb8\x88\xe8\x81\x94\xe5\x81\xa5\xe5\xba\xb7\xe4\xbc\x9a\xe5\x91\x981\xe4\xb8\xaa\xe6\x9c\x88',  'sign' => 'S+Akb7Izjpwxyq3E/5feMkcVtmdhj/1QwGu9bGmhyTwTU2Q4c2cVIwgYmbMODacrVRTKgN4A2slPQyPIgxlcr9K/uQ/AjTNbiNXzLMuptzhFNU5H5PWBu3KL8+iG/i4bcEKtpeeP3aYvfYR3MWPhnB/ENtbZUqveHAkQILoaer0C1RaN6e7NnVqoXLfALvVocmfJbQjnk8RWG8PKAOYSYfJjKyuUsOOWxCGdypfVmA2hQF2jLyEz76YW8YYe1Dg4reAHm85vUhbZRmqBWGwbk8l0W+L5Qes/Aa5l66q+ssZ55L3m1E/aw6f7+mZlpishX5UxsNb19510MBnYcB/Fug==',  'buyer_id' => '2088202285236569',  'body' => '{"order_sn":"KB-201712091603202357503437","user_id":1,"consignee":"admin","email":"1@1.com","phone":"18792512630","member_id":1,"order_name":"\\\\u4f18\\\\u5e08\\\\u8054\\\\u5065\\\\u5eb7\\\\u4f1a\\\\u54581\\\\u4e2a\\\\u6708","goods_amount":"0.01","add_time":1512806600,"end_time":2592000}',  'invoice_amount' => '0.01',  'version' => '1.0',  'notify_id' => '060bffac7bb4bed722defc96b271107kbm',  'fund_bill_list' => '[{"amount":"0.01","fundChannel":"ALIPAYACCOUNT"}]',  'notify_type' => 'trade_status_sync',  'out_trade_no' => 'KB-201712091603202357503437',  'total_amount' => '0.01',  'trade_status' => 'TRADE_SUCCESS',  'trade_no' => '2017120921001004560257725490',  'auth_app_id' => '2017101209266263',  'receipt_amount' => '0.01',  'point_amount' => '0.00',  'app_id' => '2017101209266263',  'buyer_pay_amount' => '0.01',  'sign_type' => 'RSA2',  'seller_id' => '2088721452319097',);
        
        print_r($js);
    }
}
