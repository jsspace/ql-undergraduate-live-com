<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/teacher.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span>讲师团</span>
    </div>
</div>
<div class="container-course teacher-section">
    <div class="container-inner">
        <ul class="teach-list">
            <?php 
                foreach ($teachers as $key => $teacher) { ?>
                    <li>
                        <a href="<?= Url::to(['teacher/detail', 'userid' => $teacher->id]) ?>">
                            <img class="people-img" src="<?= $teacher->picture; ?>"/>
                            <p class="intro">
                                <span class="name"><?= $teacher->username; ?></span>
                                <span class="work"><?= $teacher->description; ?></span>
                            </p>
                            <p class="intro">
                                <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                                <span class="te-text"><?= $teacher->unit; ?></span>
                            </p>
                            <p class="intro">
                                <span class="te-label">职称职务:&nbsp;&nbsp;</span>
                                <span class="te-text"><?= $teacher->office; ?></span>
                            </p>
                            <p class="intro course-area">
                                <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                <span class="te-text"><?= $teacher->goodat; ?></span>
                            </p>
                        </a>
                    </li>
            <?php } ?>
        </ul>
    </div>
</div>