<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;

AppAsset::addCss($this,'@web/css/index.css');
AppAsset::addCss($this,'@web/css/course.css');
AppAsset::addCss($this,'@web/css/data.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span>课程推荐</span>
</div>
<div class="container-course data-detail-wrapper">
    <div class="detail-title"><?= $tui->title ?></div>
    <div class="detail-date"><?= date('Y-m-d H:i:s', $tui->create_time); ?></div> 
    <div class="detail-content"><?= $tui->des ?></div>
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
        	<?php foreach ($courses as $key => $course) {?>
        		<li>
	                <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>">
	                    <div class="course-img active">
	                        <img class="course-pic" src="<?= $course->list_pic ?>">
	                    </div>
	                    <p class="content-title"><?= $course->course_name ?></p>
	                </a>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people"><?= $course->online ?>人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people"><?= $course->collection ?>人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="<?= User::getUserModel($course->teacher_id)->picture; ?>">
                        <span class="teacher-name"><?= User::item($course->teacher_id); ?></span>
                    </div>
            	</li>
        	<?php } ?>
        </ul>
    </div>
</div>