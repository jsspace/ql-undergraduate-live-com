<?php

namespace frontend\controllers;
use backend\models\GoldOrderInfo;
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

require_once "../../common/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php";
require_once "../../common/alipay/pagepay/service/AlipayTradeService.php";

require_once "../../common/wxpay/lib/WxPay.Api.php";
require_once "../../common/wxpay/example/WxPay.NativePay.php";
require_once '../../common/wxpay/example/log.php';


class WxnotifyController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['confirm_order', 'alipay'],
                'rules' => [
                    [
                        'actions' => ['confirm_order', 'alipay'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'confirm_order' => ['post'],
                    'alinotify' => ['post'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        $currentaction = $action->id;
        $novalidactions = ['wxnotify'];
        if(in_array($currentaction,$novalidactions)) {
            $action->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }




    public function actionGold()
    {
        error_log('file:'.__FILE__.'  line:'.__LINE__);
        //获取通知的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
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

                    $order_info = GoldOrderInfo::find()
                        ->where(['order_sn' => $out_trade_no])
                        ->andWhere(['order_status' => 1])
                        ->andWhere(['pay_status' => 0])
                        ->one();

                    if (!empty($order_info) && ($order_info->order_amount == $total_fee)) {
                        $order_info->pay_id = $transaction_id;
                        $order_info->pay_name = '微信支付';
                        $order_info->money_paid = intval($total_fee);
                        //再次计算金币的数量
                        $gold_num = intval($total_fee * 10);
                        $order_info->gold_num = $gold_num;
                        $order_info->pay_status = 2;
                        $order_info->pay_time = time();
                        $order_info->save(false);
                        // 赠送金币
                        $goldService = new GoldService();
                        $goldService->changeUserGold($gold_num, $order_info->user_id, '1');

                    } else {
                        $err_str = 'money is not right, $result: ' . json_encode($result);
                        $err_str .= ' file: ' . __FILE__ . ' line: ' . __LINE__ . PHP_EOL;
                        error_log($err_str);
                        return false;
                    }
                    //订单状态已更新，直接返回
                    return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';

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

    
    public function actionIndex()
    {
        error_log('file:'.__FILE__.'  line:'.__LINE__);
        //获取通知的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
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
                
                    if (!empty($order_info) && ($order_info->order_amount == $total_fee)) {
                        // attach
                        if (isset($result['attach']) && !empty($result['attach'])) {
                            $attach = json_decode($result['attach']);
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
                        
                        $order_info->pay_id = $transaction_id;
                        $order_info->pay_name = '优惠券+钱包支付+微信支付';
                        $order_info->money_paid = $total_fee;
                        $order_info->pay_status = 2;
                        $order_info->pay_time = time();
                        $order_info->save(false);
                        OrderGoods::updateAll(['pay_status' => 2], ['order_sn' => $order_sn]);
                        //标记优惠券已使用
                        Coupon::updateAll(
                            ['isuse' => 2],
                            [
                                'user_id' => $order_info->user_id,
                                'coupon_id' => explode(',', $order_info->coupon_ids),
                            ]
                            );
                        
                        //给邀请人发送奖励金额
                        //查看此人是否是被邀请注册的
                        $invite_peaple = User::find()
                        ->where(['id' => $order_info->user_id])
                        ->one();
                        $invite = $invite_peaple->invite;
                        //查看是否是第一次购买
                        $is_first_order = OrderInfo::find()
                        ->andWhere(['user_id' => $order_info->user_id])
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
                        
                        
                        
                    } else {
                        $err_str = 'money is not right, $result: ' . json_encode($result);
                        $err_str .= ' file: ' . __FILE__ . ' line: ' . __LINE__ . PHP_EOL;
                        error_log($err_str);
                        return false;
                    }
                    //订单状态已更新，直接返回
                    return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
                    
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
