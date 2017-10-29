<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Coupon;
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
            <p class="current-status">全部</p>
            <ul class="status-list">
                <li class="active">全部</li>
                <li>未使用</li>
                <li>使用中</li>
                <li>已使用</li>
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
                <?php foreach ($coupons as $key => $coupon) { 
                    //$coupon->isuse 0:未使用 1 使用中 2 已使用
                ?>
                <li coupon-status="<?= $coupon->isuse ?>">
                    <p class="coupon-name"><?= $coupon->name ?></p>
                    <p class="coupon-money">￥<?= $coupon->fee ?></p>
                    <p class="coupon-status"><?= Coupon::item($coupon->isuse) ?></p>
                    <p class="coupon-daterange"><?= date('Y-m-d', strtotime($coupon->start_time)) ?>至<?= date('Y-m-d', strtotime($coupon->end_time)) ?></p>
                </li>
                <?php } ?>
            </ul>
            <?php if (count($coupons) == 0) { ?>
                <div class="coupon-content-line empty-coupon">
                    暂无可用优惠券
                </div>
            <?php } ?>
        </div>
    </div>
</div>