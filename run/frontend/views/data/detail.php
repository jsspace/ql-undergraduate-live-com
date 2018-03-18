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
    <div class="detail-title"><?= $dataDetail->name; ?></div>
    <div class="detail-date"><?= date('Y-m-d H:i:s', $dataDetail->ctime); ?></div> 
    <div class="detail-content"><?= $dataDetail->content; ?></div>
</div>