<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/order.css');

$this->title = '付款方式';
?>
<?php if (!empty($code_url)) {?>
<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式二</div><br/>
	<img alt="模式二扫码支付" src="<?= $code_url; ?>" style="width:150px;height:150px;"/>
</div>
<input type="hidden" name="out_trade_no" id="out_trade_no" value="<?= $out_trade_no;?>" />
<script>
$(function(){
   setInterval(function(){check()}, 5000);  //5秒查询一次支付是否成功
})
function check() {
	$.ajax({
        url: "<?= Url::to(['order-info/wxcheckorder']) ?>",
        type: 'post',
        dataType:"json",
        data: {
            'out_trade_no': $("#out_trade_no").val(),
            '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
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
