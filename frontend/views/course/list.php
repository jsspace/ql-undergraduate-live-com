<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use yii\widgets\LinkPager;

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
                            <span class="content-title"><?= $course->course_name; ?></span>
                            <span class="course-time"><?= date('Y-m-d H:i', $course->create_time); ?></span>
                        </a>
                        <div class="teacher-section">
                            <!-- <img src="<?= User::getUserModel($course->teacher_id)->picture; ?>"/> -->
                            <span class="teacher-name">主讲人：<?= User::item($course->teacher_id); ?></span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <div class="clear"></div>
            <?php 
                echo LinkPager::widget([
                    'pagination' => $pages,
                    'firstPageLabel'=>"首页",
                    'lastPageLabel'=>'尾页',
                ]);
            ?>
        </div>
    </div>
</div>
