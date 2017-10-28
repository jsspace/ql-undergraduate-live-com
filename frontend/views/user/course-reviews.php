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
        <p class="user-right-title">课程评价</p>
        <ul class="user-evaluate">
            <li>
                <div class="evaluate-left">
                    <p class="evaluate-img"><a href=""><img src="/img/course-list-img.jpg"/></a></p>
                    <p class="evaluate-course-name"><a href="">前端课程前端课程</a></p>
                </div>
                <div class="evaluate-right">
                    <div class="star">
                        <img src="/img/star-on.png">
                        <img src="/img/star-on.png">
                        <img src="/img/star-on.png">
                        <img src="/img/star-on.png">
                        <img src="/img/star-off.png">
                    </div>
                    <div class="evaluate-content">这个课程不错，老师讲的很清晰，老师讲的很清晰</div>
                    <div class="evaluate-date">2017-10-20</div>
                </div>
            </li>
        </ul>
    </div>
</div>