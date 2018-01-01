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
<input type="hidden" name="out_trade_no" id="out_trade_no" value="<?php echo $out_trade_no;?>" />
<script>
    $(function(){
       setInterval(function(){check()}, 5000);  //5秒查询一次支付是否成功
    })
    function check(){
        var url = "http://localhost/WxpayAPI_php_v3/example/orderquery2.php";　　//新建
        var out_trade_no = $("#out_trade_no").val();
        var param = {'out_trade_no':out_trade_no};
        $.post(url, param, function(data){
            data = JSON.parse(data);
            if(data['trade_state'] == "SUCCESS"){
                alert(JSON.stringify(data));
                alert("订单支付成功,即将跳转...");
                window.location.href = "http://localhost/WxpayAPI_php_v3/index.php";
            }else{
                console.log(data);
            }
        });
    }
</script>
<?php } else {?>
<div>
<?= $return_msg; ?>
</div>
<?php }?>
