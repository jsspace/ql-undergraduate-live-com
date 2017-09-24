<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/order.css');

$this->title = '订单详情';
?>

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
                <p class="order-txt">订单编号：&nbsp;&nbsp;&nbsp;&nbsp;XHSOP90234</p>
                <p class="order-txt">订单内容：</p>
                <ul class="order-list">
                    <li>
                        <div class="cart-course-detail">
                            <div class="cart-img">
                                <img src="/img/course-list-img.jpg"/>
                            </div>
                            <div class="cart-txt">
                                <span class="name">前端课程设计</span>
                                <span class="price">价格：￥1800.00</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <p class="total-summary">订单总额：<span class="price-high">￥1800.00</span></p>
            </div>
        </div>
        <div class="order-payment-method">
            <div class="inner-order">
                <h3>订单支付方式</h3>
                <div class="payment-method">
                    <input type="radio" name="payment-method"/>
                    <span>在线支付</span>
                    <span class="payment-desc"> 选择在线支付订单，可使用学习券、优惠券或奖学金抵消部分订单总额；在线支付成功后，系统自动为您开通课程权限。</span>
                </div>
            </div>
        </div>
        <div class="order-payment-method discount">
            <div class="inner-order">
                <h3>可使用优惠券</h3>
                <div class="no-discount" style="display: none">暂无可使用优惠券</div>
                <ul class="discount-list">
                    <li>
                        <input type="radio" name="discount"/>
                        <span class="discount-img"><img src="/img/discount.jpg"/></span>
                        <span class="discount-desc">新会员50元优惠券</span>
                    </li>
                    <li>
                        <input type="radio" name="discount"/>
                        <span class="discount-img"><img src="/img/discount.jpg"/></span>
                        <span class="discount-desc">新会员50元优惠券</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="order-payment-method order-total">
            <div class="inner-order">
                <div class="left">
                    <span>订单总额： ￥1800.00</span>
                    <span>已优惠：<i>￥0.00</i></span>
                </div>
                <div class="right">
                    应付总额：<span class="price-high">￥1800.00</span>
                    <a href="" class="btn">提交订单</a>
                </div>
            </div>
        </div>
    </div>
</div>