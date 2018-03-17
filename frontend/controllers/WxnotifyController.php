<?php

namespace frontend\controllers;
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
        parent::beforeAction($action);
        return true;
    }


    
    public function actionIndex()
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
                    $total_fee = $result['total_fee'];
                    //支付完成时间
                    $time_end = $result['time_end'];
                
                
                    $order_info = OrderInfo::find()
                    ->where(['order_sn' => $out_trade_no])
                    ->andWhere(['order_status' => 1])
                    ->andWhere(['pay_status' => 0])
                    ->one();
                
                    if (!empty($order_info)) {
                        if (($order_info->order_amount*100) == $total_fee) {
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
