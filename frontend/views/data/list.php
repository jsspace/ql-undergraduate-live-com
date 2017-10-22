<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/data.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span>资料下载</span>
</div>
<div class="data-wrapper">
    <ul class="data-inner">
        <li>
            <img class="course-data-img" src="/uploads/img/data/15085852383846.png">
            <div class="right-con">
                <p class="data-title">
                    <span class="data-label">考本必读</span>
                    <span><a target="_blank" href="http://www.baidu.com&#10;">新闻摄影：观众的“眼睛”</a></span>
                </p>
                <p class="data-intro">相信每个人都看过中央一台的《新闻联播》，对于其中的会议画面更是司空见...</p>
            </div>
        </li>
        <li>
            <img class="course-data-img" src="/uploads/img/data/15085852383846.png">
            <div class="right-con">
                <p class="data-title">
                    <span class="data-label">考本必读</span>
                    <span><a target="_blank" href="http://www.baidu.com&#10;">新闻摄影：观众的“眼睛”</a></span>
                </p>
                <p class="data-intro">相信每个人都看过中央一台的《新闻联播》，对于其中的会议画面更是司空见...</p>
            </div>
        </li>
        <li>
            <img class="course-data-img" src="/uploads/img/data/15085852383846.png">
            <div class="right-con">
                <p class="data-title">
                    <span class="data-label">考本必读</span>
                    <span><a target="_blank" href="http://www.baidu.com&#10;">新闻摄影：观众的“眼睛”</a></span>
                </p>
                <p class="data-intro">相信每个人都看过中央一台的《新闻联播》，对于其中的会议画面更是司空见...</p>
            </div>
        </li>
        <li>
            <img class="course-data-img" src="/uploads/img/data/15085852383846.png">
            <div class="right-con">
                <p class="data-title">
                    <span class="data-label">考本必读</span>
                    <span><a target="_blank" href="http://www.baidu.com&#10;">新闻摄影：观众的“眼睛”</a></span>
                </p>
                <p class="data-intro">相信每个人都看过中央一台的《新闻联播》，对于其中的会议画面更是司空见...</p>
            </div>
        </li>
    </ul>
</div>