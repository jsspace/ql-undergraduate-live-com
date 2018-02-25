<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\CourseCategory;

AppAsset::addCss($this,'@web/css/college.css');

$this->title = '直属学院';
?>
<div class="college-list">
    <div class="college-banner _college-banner">
        <img src="<?= $collegeArr['college']->detail_icon ?>">
    </div>
    <div class="college-content">
        <div class="college-category">
            <h3 class="college-all">全部学院</h3>
            <ul class="college-category-list _college-category-list">
                <?php foreach ($all_colleges as $key => $all_college) { ?>
                    <li><a class="<?php if ($all_college->id === $collegeArr['college']->id) echo 'active' ?>" href="<?= Url::to(['course/college', 'cat' => $all_college->id]) ?>"><?= $all_college->name ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="college-right">
            <ul class="college-tab _college-tab">
                <li>
                    <span>学院介绍</span>
                </li>
                <li class="active">
                    <span>课程列表</span>
                </li>
                <li>
                    <span>班级列表</span>
                </li>
                <li>
                    <span>师资力量</span>
                </li>
            </ul>
            <ul class="college-category-con _college-category-con">
                <li class="college-intro">
                    <?= $collegeArr['college']->des ?>
                </li>
                <li class="college-course active">
                    <div class="user-course-list">
                        <?php 
                        if (!empty($collegeArr["college_course"])) {
                        foreach ($collegeArr["college_course"] as $key => $course) { ?>
                        <div class="course-list-con">
                            <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>" class="user-course-img" target="_blank"><img src="<?= $course->list_pic ?>"/></a>
                            <div class="user-course-details">
                                <h3><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>" title="" target="_blank"><?= $course->course_name ?></a></h3>
                                <div class="row">主讲老师: <?= User::item($course->teacher_id); ?></div>
                                <div class="row">
                                    <div class="btns">
                                        <a class="btn btn-primary" target="_blank" href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>">进入学习</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } } ?>
                    </div>
                </li>
                <li class="college-class">
                    <div class="user-course-list">
                        <?php
                            if (!empty($collegeArr["college_class"])) {
                                foreach ($collegeArr["college_class"] as $key => $collegeclass) { ?>
                                    <div class="course-list-con">
                                        <a href="<?= Url::to(['package/detail', 'pid' => $collegeclass->id]) ?>" class="user-course-img"><img src="<?= $collegeclass->list_pic ?>"/></a>
                                        <div class="user-course-details">
                                            <h3><a href="<?= Url::to(['package/detail', 'pid' => $collegeclass->id]) ?>" title=""><?= $collegeclass->name ?></a></h3>
                                            <div class="row">班主任: <?= User::item($collegeclass->head_teacher); ?></div>
                                            <div class="row">
                                                <div class="btns">
                                                    <a class="btn btn-primary" href="<?= Url::to(['package/detail', 'pid' => $collegeclass->id]) ?>">办理入学</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                        <?php } ?>
                    </div>
                </li>
                <li class="teacher-section">
                    <div class="teach-list">
                        <?php 
                            if (!empty($collegeArr["college_teacher"])) {
                            foreach ($collegeArr["college_teacher"] as $key => $teacher) { ?>
                            <div class="teacher-con">
                                <a href="<?= Url::to(['teacher/detail', 'userid' => $teacher->id]) ?>" target="_blank">
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
                                    <p class="intro">
                                        <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                        <span class="te-text"><?= $teacher->goodat; ?></span>
                                    </p>
                                </a>
                            </div>
                        <?php } } ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="/js/course-list.js"></script>