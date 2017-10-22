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
<div class="container-course data-detail-wrapper">
    <div class="detail-title">教你如何玩转摄影构图</div>
    <div class="detail-date">2017-06-05 13:26:46</div> 
    <div class="detail-content">内容</div>
</div>