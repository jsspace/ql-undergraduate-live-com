<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/index.css');
AppAsset::addCss($this,'@web/css/course.css');
AppAsset::addCss($this,'@web/css/data.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span>资料下载</span>
</div>
<div class="container-course data-detail-wrapper">
    <div class="detail-title">教你如何玩转摄影构图</div>
    <div class="detail-date">2017-06-05 13:26:46</div> 
    <div class="detail-content">内容</div>
</div>
<div class="container-course data-course-wrapper">
    <h3 class="course-title">相关课程</h3>
        <fieldset>
            <legend>
                <img src="/img/arrow-icon.jpg">
            </legend>
    </fieldset>
    <div class="course-content">
        <ul class="list">
            <li>
                <a href="/course/detail?courseid=2">
                    <div class="course-img active">
                        <img class="course-pic" src="/uploads/img/course/15043216071946.jpg">
                    </div>
                    <p class="content-title">语文基础课程</p>
                </a>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">34人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">10人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg">
                        <span class="teacher-name">ert</span>
                    </div>
            </li>
        </ul>
    </div>
</div>