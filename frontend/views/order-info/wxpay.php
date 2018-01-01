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
<?php } else {?>
<div>
<?= $return_msg; ?>
</div>
<?php }?>