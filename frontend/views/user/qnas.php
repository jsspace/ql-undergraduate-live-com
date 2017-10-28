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
        <p class="user-right-title">我的提问</p>
        <ul class="user-question-list">
            <li>
                <span class="course-img"><a href=""><img src="/img/course-list-img.jpg"/></a></span>
                <div class="question-content">
                    <p class="question-answer">
                        <span class="question-icon">问</span>
                        <span class="question-txt">为什么这个课程老是这么卡，有没有解决方法？</span>
                    </p>
                    <p class="question-answer">
                        <span class="question-icon">答</span>
                        <span class="question-txt">那是你网不好吧，换个4G网络怎么样</span>
                    </p>
                </div>
                <p class="question-date">2017-09-29 19:32:00</p>
            </li>
            <li>
                <span class="course-img"><img src="/img/course-list-img.jpg"/></span>
                <div class="question-content">
                    <p class="question-answer">
                        <span class="question-icon">问</span>
                        <span class="question-txt">为什么这个课程老是这么卡，有没有解决方法？为什么这个课程老是这么卡，有没有解决方法？</span>
                    </p>
                    <p class="question-answer">
                        <span class="question-icon">答</span>
                        <span class="question-txt">那是你网不好吧，换个4G网络怎么样那是你网不好吧，换个4G网络怎么样</span>
                    </p>
                </div>
                <p class="question-date">2017-09-29 19:32:00</p>
            </li>
        </ul>
    </div>
</div>