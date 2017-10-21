<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/order.css');

$this->title = '付款方式';
?>

<div class="order-wrapper order-detail-section">
    <div class="step-wrapper">
        <ul class="order-step">
            <li class="step1 finished">
                <i class="icon ion-ios-checkmark-empty"></i>
                <span>我的购物车</span>
            </li>
            <li class="step2 finished">
                <i class="icon ion-ios-checkmark-empty"></i>
                <span>确认订单信息</span>
            </li>
            <li class="step3 current">
                <i class="icon ion-pricetag"></i>
                <span>支付订单</span>
            </li>
        </ul>
    </div>
    <div class="order-payment-method payway-wrapper">
        <div class="inner-order">
            <div class="right-icon"><i class="icon ion-ios-checkmark-outline"></i></div>
            <div class="order-success-txt">
                <h2>订单提交成功，请您尽快付款</h2>
                <div class="first">
                    订单编号：<span class="blue-light"><?= $order_sn ?></span>
                    应付金额：<span class="orange">￥1800.00</span>
                </div>
                <div class="grey">
                    请您在提交订单后 <span class="orange">24小时内</span> 完成支付，否则订单将会自动取消
                </div>
            </div>
        </div>
    </div>
    <div class="order-payment-method payway-method">
        <div class="inner-order">
            <h3>支付方式</h3>
            <div class="txt">请选择以下支付方式：</div>
            <ul class="method-list">
                <li class="ipay active">
                </li>
                <li class="wechat-pay">
                </li>
            </ul>
        </div>
    </div>
    <div class="order-payment-method payway-method last-banner">
        <div class="inner-order">
            <a href="" class="go-back blue-light">&lt;&nbsp;&nbsp;返回上一步</a>
            <a href="" class="btn">一次性支付</a>
        </div>
    </div>
</div>