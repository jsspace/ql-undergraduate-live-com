<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;

AppAsset::addCss($this,'@web/css/user.css');
AppAsset::addCss($this,'@web/css/vip.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
    </div>
</div>
<div class="user-wrapper site-vip">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <p class="user-right-title">我的班级会员</p>
        <div class="vip-section">
            <p class="vip-title">健康学院</p>
            <ul class="college-class">
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">查看详情</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">查看详情</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">查看详情</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="vip-section">
            <p class="vip-title">健康学院</p>
            <ul class="college-class">
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">查看详情</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">查看详情</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">查看详情</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>