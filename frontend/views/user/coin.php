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
        <p class="user-right-title">我的金币</p>
        <p class="coin-con">
            <span class="coin-left">
                金币余额：0元&nbsp;&nbsp;&nbsp;&nbsp;<a href="">充值金币</a>
            </span>
            <span class="coin-right">不知道如何充值或使用金币？<a href="">请戳这里</a></span>
        </p>
        <div class="coupon-wrapper coin-wrapper">
            <ul class="coupon-title-line">
                <li class="coin-id">ID</li>
                <li>收支</li>
                <li>金币余额</li>
                <li class="coin-detail">操作明细</li>
                <li>操作时间</li>
            </ul>
            <ul class="coupon-content-line">
                <li>
                    <p class="coin-id">1</p>
                    <p>45元</p>
                    <p>50元</p>
                    <p class="coin-detail">支付宝支付</p>
                    <p>2017年12月2日</p>
                </li>
                <li>
                    <p class="coin-id">1</p>
                    <p>45元</p>
                    <p>50元</p>
                    <p class="coin-detail">支付宝支付</p>
                    <p>2017年12月2日</p>
                </li>
            </ul>
        </div>
    </div>
</div>