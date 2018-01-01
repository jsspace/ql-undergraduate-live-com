<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
    </div>
</div>
<div class="user-wrapper">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <p class="user-right-title">我的课程</p>
        <ul class="user-course-list">
            <?php foreach ($clist as $key => $course) { ?>
                <li>
                    <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>" class="user-course-img"><img src="<?= $course->list_pic ?>"/></a>
                    <div class="user-course-details">
                        <h3><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>" title="<?= $course->course_name ?>" target="_blank"><?= $course->course_name ?></a></h3>
                        <div class="row">主讲老师: <?= User::item($course->teacher_id); ?></div>
                        <div class="row">
                            <div class="btns">
                                <a class="btn btn-primary" target="_blank" href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>">进入学习</a>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <?php if (count($clist) == 0) { ?>
        <div class="empty-content">您还没有选择任何课程哦~赶紧去<a href="/course/list" class="go-link">挑选课程&gt;&gt;</a></div>
        <?php } ?>
    </div>
</div>