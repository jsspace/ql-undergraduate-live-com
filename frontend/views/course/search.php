<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\CourseCategory;

AppAsset::addCss($this,'@web/css/course.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span>查询结果</span>
</div>
<div class="container-course course-section">
    <div class="course-content">
        <ul class="list">
            <?php foreach ($coursemodels as $course) { ?>
                <li>
                    <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>">
                        <div class="course-img">
                            <img class="course-pic" src="<?= $course->list_pic ?>"/>
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
                            <img src="<?= User::getUserModel($course->teacher_id)->picture; ?>"/>
                            <span class="teacher-name"><?= User::item($course->teacher_id); ?></span>
                        </div>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="no-result">
        <img src="/img/no-results.png">
        <h5>抱歉，没有找到相关课程</h5>
        <p>请换个关键词重新搜索</p>
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="/js/course-list.js"></script>