<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
</div>
<div class="user-wrapper">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <p class="user-right-title">我的优惠券</p>
        <div class="status-select-wrapper">
            <p class="current-status">未使用</p>
            <ul class="status-list">
                <li class="active">未使用</li>
                <li>已使用</li>
                <li>已过期</li>
            </ul>
        </div>
        <div class="coupon-wrapper">
            <ul class="coupon-title-line">
                <li class="coupon-name">优惠券名称</li>
                <li class="coupon-money">优惠券金额</li>
                <li class="coupon-status">使用状态</li>
                <li class="coupon-daterange">有效期</li>
            </ul>
            <ul class="coupon-content-line">
                <li>
                    <p class="coupon-name">用户推荐码专属优惠券</p>
                    <p class="coupon-money">￥100</p>
                    <p class="coupon-status">未使用</p>
                    <p class="coupon-daterange">2017-10-1至永久</p>
                </li>
                <li>
                    <p class="coupon-name">用户推荐码专属优惠券</p>
                    <p class="coupon-money">￥100</p>
                    <p class="coupon-status">未使用</p>
                    <p class="coupon-daterange">2017-10-1至永久</p>
                </li>
                <li>
                    <p class="coupon-name">用户推荐码专属优惠券</p>
                    <p class="coupon-money">￥100</p>
                    <p class="coupon-status">未使用</p>
                    <p class="coupon-daterange">2017-10-1至永久</p>
                </li>
            </ul>
            <div class="coupon-content-line empty-coupon">
            暂无可用优惠券
            </div>
        </div>
    </div>
</div>