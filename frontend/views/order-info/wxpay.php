<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/order.css');

$this->title = '付款方式';
?>
<?php if (!empty($code_url)) {?>
<div class="wx-pay-erweima">
    <p>请使用微信扫一扫，扫描下面的二维码支付。支付成功后，系统将自动为您开通课程学习权限。</p>
    <div class="left">
        <img alt="模式二扫码支付" src="<?= $code_url; ?>"/>
        <p>请使用微信扫一扫</p>
        <p>扫描二维码支付</p>
    </div>
    <div class="right">
        <img src="/img/wx-pay-tip.jpg">
    </div>
</div>
<input type="hidden" name="out_trade_no" id="out_trade_no" value="<?= $out_trade_no;?>" />
<script>
$(function(){
   setInterval(function(){check()}, 5000);  //5秒查询一次支付是否成功
})
function check() {
	$.ajax({
        url: "<?= Url::to(['order-info/wxcheckorder']) ?>",
        type: 'get',
        dataType:"json",
        data: {
            'out_trade_no': $("#out_trade_no").val(),
        },
        success: function(data) {
            if (data.trade_state == "SUCCESS") {
            	alert("订单支付成功,即将跳转...");
                window.location.href = "<?= Url::to(['user/orders']) ?>";
            }
        }
    });
}
</script>
<?php } else {?>
<div>
<?= $return_msg; ?>
</div>
<?php }?>
