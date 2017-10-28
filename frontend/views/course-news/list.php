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
    <span>课程推荐</span>
</div>
<div class="data-wrapper">
    <ul class="data-inner">
        <?php foreach ($tjcourses as $key => $tjcourse) { ?>
            <li>
                <img class="course-data-img" src="<?= $tjcourse->list_pic ?>"/>
                <div class="right-con">
                    <p class="data-title">
                        <span class="data-label">考本必读</span>

                        <span><a href="<?= Url::to(['course-news/detail', 'newsid' => $tjcourse->id]) ?>"><?= $tjcourse->title ?></a></span>
                    </p>
                    <p class="data-intro"><?= $tjcourse->des ?></p>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>