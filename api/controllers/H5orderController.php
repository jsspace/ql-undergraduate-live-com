<?php

namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Url;
use yii\rest\ActiveController;

use backend\models\OrderInfo;
use common\models\User;
use backend\models\OrderGoods;

require_once "../common/h5_wxp/lib/WxPay.Api.php";
require_once "../common/h5_wxp/example/WxPay.JsApiPay.php";
require_once "../common/h5_wxp/example/WxPay.Config.php";
require_once '../common/h5_wxp/example/log.php';

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class H5orderController extends ActiveController
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

    /**
     * 流程：
     * 1、调用统一下单，取得code_url，生成二维码
     * 2、用户扫描二维码，进行支付
     * 3、支付完成之后，微信服务器会通知支付成功
     * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
     */

    // h5 支付参数获取
    public function actionGetJsApiParam()
    {
        $get = Yii::$app->request->get();
        $order_sn = $get['order_sn'];
        $access_token = $get['access-token'];
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

        $code = $get['code'];
        if (empty($code)) {
            $data = [
                'status' => -1,
                'message' => '参数错误'
            ];
            return $data;
        }

        $weixin_pay = number_format($orderInfo->order_amount, 2);

        //①、获取用户openid
        try {

            $tools = new \JsApiPay();
            $openId = $tools->GetOpenid($code);

            //②、统一下单
            $input = new \WxPayUnifiedOrder();
            $input->SetBody(trim('课程购买订单：'.$order_sn));
            $input->SetAttach($orderInfo->order_sn);
            $input->SetOut_trade_no($order_sn);
            $input->SetTotal_fee($weixin_pay * 100);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            //$input->SetGoods_tag("test");

            $config = Yii::$app->params['wxpay'];

            $input->SetNotify_url($config['notify_url']);
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            $config = new \WxPayConfig();
            $order = \WxPayApi::unifiedOrder($config, $input);
            $jsApiParameters = $tools->GetJsApiParameters($order);
            $data = [
                'status' => 0,
                'jsApiParameters' => $jsApiParameters
            ];
            return $data;
            //获取共享收货地址js函数参数
            //$editAddress = $tools->GetEditAddressParameters();
        } catch(Exception $e) {
            Log::ERROR(json_encode($e));
        }
    }
    // 获取appid
    public function actionGetAppid() {
        $get = Yii::$app->request->get();
        $access_token = $get['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        if (empty($user)) {
            $result = [
                'status' => -1,
                'message' => '请先登录后再操作'
            ];
        } else {
            $result =  [
                'status' => 0,
                'appid' => Yii::$app->params['wxpay']['h5_appid'],
                'message' => '获取成功'
            ];
        }
        return $result;
    }

    // 订单支付状态
    public function actionWxcheckorder()
    {
        $data = Yii::$app->request->get();
        if(!empty($data["out_trade_no"])){
            $out_trade_no = $data["out_trade_no"];
            $input = new \WxPayOrderQuery();
            $input->SetOut_trade_no($out_trade_no);
            $config = new \WxPayConfig();
            $result = \WxPayApi::orderQuery($config, $input);
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
                                
                            }
                            //给邀请人发送奖励金额
                            //查看此人是否是被邀请注册的
                            $invite_peaple = User::find()
                            ->where(['id' => $order_info->user_id])
                            ->one();
                            $invite = $invite_peaple->invite;
                            OrderGoods::updateAll(['pay_status' => 2], ['order_sn' => $out_trade_no]);
                            $order_info->pay_id = $transaction_id;
                            $order_info->pay_name = '微信支付';
                            $order_info->money_paid = $total_fee;
                            $order_info->pay_status = 2;
                            $order_info->pay_time = time();
                            $order_info->save(false);
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
            return json_encode($result);
        }
    }
}
