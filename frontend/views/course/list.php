<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\CourseCategory;

AppAsset::addCss($this,'@web/css/list.css');

$this->title = '新课提醒';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span>新课提醒</span>
</div>
<div class="container-course course-online">
    <div class="container-course-wrap">
        <div class="course-content">
            <ul class="list">
                <?php foreach ($courses as $course) { ?>
                    <li>
                        <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>">
                            <div class="course-img">
                                <img class="course-pic" src="<?= $course->list_pic; ?>"/>
                            </div>
                            <p class="content-title"><?= $course->course_name; ?></p>
                        </a>
                        <div class="teacher-section">
                            <!-- <img src="<?= User::getUserModel($course->teacher_id)->picture; ?>"/> -->
                            <span class="teacher-name">主讲人：<?= User::item($course->teacher_id); ?></span>
                            <span class="teacher-position"><?= CourseCategory::getNames($course->category_name); ?></span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
