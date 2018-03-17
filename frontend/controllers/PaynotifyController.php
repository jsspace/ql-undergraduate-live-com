<?php
namespace frontend\controllers;

use backend\models\Coupon;
use backend\models\OrderInfo;

require_once "../../common/wxpay/lib/WxPay.Api.php";
require_once "../../common/wxpay/lib/WxPay.Notify.php";


class PaynotifyController extends \WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new \WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		error_log("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
	    //商户订单号
	    $out_trade_no = $data['out_trade_no'];
	    //微信支付订单号
	    $transaction_id = $data['transaction_id'];
	    //交易类型
	    $trade_type = $data['trade_type'];
	    //支付金额(单位：元)
	    $total_fee = $data['total_fee']/100.00;
	    //支付完成时间
	    $time_end = $data['time_end'];
	    
	    $order_info = OrderInfo::find()
	    ->where(['order_sn' => $out_trade_no])
	    ->andWhere(['order_status' => 1])
	    ->one();
	    if (empty($order_info)) {
	        $msg = "没有这个订单";
	        return false;
	    }
	    
		error_log("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"]) && $order_info->order_amount != $total_fee){
			$msg = "订单查询失败";
			return false;
		}
		
	    if ($order_info->pay_status == 0) {
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
		
		return true;
	}
}

error_log("begin notify");
$notify = new Paynotify();
$notify->Handle(false);
