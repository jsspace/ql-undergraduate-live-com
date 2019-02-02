<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/order.css');

$this->title = '订单详情';
AppAsset::addScript($this,'@web/js/shopping.js?v='.time());
?>
<!----订单页面---->
<div class="order-wrapper order-detail-section">
    <div class="step-wrapper">
        <ul class="order-step">
            <li class="step1 finished">
                <i class="icon ion-ios-checkmark-empty"></i>
                <span>我的购物车</span>
            </li>
            <li class="step2 current">
                <i class="icon ion-document-text"></i>
                <span>确认订单信息</span>
            </li>
            <li class="step3">
                <i class="icon ion-pricetag"></i>
                <span>支付订单</span>
            </li>
        </ul>
    </div>
    <div class="order-detail-wrapper">
        <div class="order-top">
            <div class="inner-order">
                <h3>订单详情</h3>
                <p class="order-txt">订单编号：&nbsp;&nbsp;&nbsp;&nbsp;<?= $order_sn ?></p>
                <p class="order-txt">金币数量：<span class="price-high"><?= $gold_num ?> 个 </span></p>
                <p class="total-summary">订单总额：<span class="price-high">￥<?= $money ?></span></p>
            </div>
        </div>
        <div class="order-payment-method order-total">
            <div class="inner-order">
                <div class="left">
                    <span>订单总额： ￥<?=  $money ?></span>
                    <span class="discount-price _discount-price">已优惠：<i></i></span>
                </div>
                <div class="right">
                    <?php $form = ActiveForm::begin(['id' => 'order-confirm-form', 'action' => Url::to(['order-info/gold_confirm_order','order_sn' => $order_sn])]); ?>
                    应付总额：<span class="price-high">￥<span class="_total-price"><?=  $money ?></span></span>
                    <input type="hidden" name="gold_num" class="gift_books" value="<?=  $gold_num ?>">
                    <input type="hidden" name="money" class="gift_coins" value="<?=  $money ?>">
                    <?= Html::submitButton('提交订单', ['class' => 'btn btn-confirm']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
