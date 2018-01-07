<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/card.css');

$this->title = '如何使用钱包购买课程';
?>

<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span>如何使用钱包购买课程</span>
    </div>
</div>

<div class="container-course">
    <div class="container-inner">
        <div class="howto-container">
            <p class="howto-title"><i class="icon ion-ios-navigate-outline"></i>1. 钱包是什么？</p>
            <p class="howto-con">钱包是本网站统一使用的虚拟货币。可以用于购买课程和购买官网上面的周边产品。</p>
            <p class="howto-title"><i class="icon ion-ios-navigate-outline"></i>2. 如何进行钱包充值呢？</p>
            <p class="howto-con">
                <span>(1) 首先你要有一张学习充值卡。</span>
                <span>(2) 登录官网，没有账号的童鞋请先注册。</span>
                <span>(3) 打开钱包充值页面：<a href="/card">http://www.kaoben.top/card</a>。</span>
                <span>(4) 在输入框内输入16位学习卡密码并提交充值。</span>
                <img src="/img/card01.png"/>
                <img src="/img/card02.png"/>
                <span>(5) 充值成功后会自动跳转到个人中心—我的钱包页面，即可查看自己的充值记录。</span>
            </p>
            <p class="howto-title"><i class="icon ion-ios-navigate-outline"></i>3. 如何使用钱包来购买课程呢?</p>
            <p class="howto-con">
                <span>(1) 进入你要购买的课程的页面，点击购买</span>
                <img src="/img/card03.png"/>
                <span>(2) 提交订单后，选择我的钱包支付方式，选择立即支付即可完成</span>
                <img src="/img/card04.png"/>
                <img src="/img/card05.png"/>
                <span style="color: rgb(227,108,9); font-size: 15px;">注意：如若钱包余额不足是购买不了课程的，这时候同学们请前往<a href="/card" style="color: rgb(227,108,9)">  http://www.kaoben.top/card  </a>先进行充值</span>
            </p>
        </div>
    </div>
</div>