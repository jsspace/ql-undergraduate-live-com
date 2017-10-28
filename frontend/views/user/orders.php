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
        <p class="user-right-title">我的订单</p>
        <div class="status-select-wrapper">
            <p class="current-status">全部状态</p>
            <ul class="status-list">
                <li class="active">全部状态</li>
                <li>等待付款</li>
                <li>已完成</li>
            </ul>
        </div>
        <ul class="order-list">
            <li class="order-list-item">
                <div class="order-title-line">
                    <span class="order-time">2017-09-20 17:34:23</span>
                    <span class="order-number">订单号：<em>5049302930</em></span>
                </div>
                <div class="order-content">
                    <p class="course-img"><a href=""><img src="/img/course-list-img.jpg"/></a></p>
                    <p class="course-name"><a href="">前端课程前端课程前端课程前端课程前端课程前端课程前端课程</a></p>
                    <p class="course-quantity">&times; 1</p>
                    <p class="order-price">
                        <span class="total-price">总额：￥999.00</span>
                        <span class="pay-method">在线支付</span>
                    </p>
                    <p class="order-status">已完成</p>
                </div>
                <div class="order-content">
                    <p class="course-img"><a href=""><img src="/img/course-list-img.jpg"/></a></p>
                    <p class="course-name"><a href="">前端课程前端课程前端课程前端课程前端课程前端课程前端课程</a></p>
                    <p class="course-quantity">&times; 1</p>
                    <p class="order-price">
                        <span class="total-price">总额：￥999.00</span>
                        <span class="pay-method">在线支付</span>
                    </p>
                    <p class="order-status">已完成</p>
                </div>
            </li>
            <li class="order-list-item">
                <div class="order-title-line">
                    <span class="order-time">2017-09-20 17:34:23</span>
                    <span class="order-number">订单号：<em>5049302930</em></span>
                </div>
                <div class="order-content">
                    <p class="course-img"><a href=""><img src="/img/course-list-img.jpg"/></a></p>
                    <p class="course-name"><a href="">前端课程前端课程前端课程前端课程前端课程前端课程前端课程</a></p>
                    <p class="course-quantity">&times; 1</p>
                    <p class="order-price">
                        <span class="total-price">总额：￥999.00</span>
                        <span class="pay-method">在线支付</span>
                    </p>
                    <p class="order-status">已完成</p>
                </div>
                <div class="order-content">
                    <p class="course-img"><a href=""><img src="/img/course-list-img.jpg"/></a></p>
                    <p class="course-name"><a href="">前端课程前端课程前端课程前端课程前端课程前端课程前端课程</a></p>
                    <p class="course-quantity">&times; 1</p>
                    <p class="order-price">
                        <span class="total-price">总额：￥999.00</span>
                        <span class="pay-method">在线支付</span>
                    </p>
                    <p class="order-status">已完成</p>
                </div>
            </li>
        </ul>
    </div>
</div>