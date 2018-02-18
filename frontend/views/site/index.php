<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\CourseCategory;

AppAsset::addCss($this,'@web/css/index.css');

$this->title = '首页';

$weekarray=array("日","一","二","三","四","五","六"); 

?>
<div class="site-index">
    <div class="live-course">
        <div class="live-course-container">
            <div class="left-video">
                <!-- <img src="/img/no-video.jpg" class="no-video"/> -->
                <a href="javascript:void(0)" class="enter-video-btn _video-btn" target="_blank">进入教室</a>
            </div>
            <div class="right-list">
                <div class="data-title">
                    <span class="time"><?= date("m").'月'.date("d").'日' ?>&nbsp;&nbsp;<?= '星期'.$weekarray[date("w")] ?></span>
                </div>
                <?php
                    /*$viewername = '';
                    $viewertoken = '';
                    if (!Yii::$app->user->isGuest) {
                    $viewername = User::getUserModel(Yii::$app->user->id)->username;
                    $viewertoken = User::getUserModel(Yii::$app->user->id)->password_hash;*/
                //} ?>
                <ul class="video-title-list _video-list">
                    <?php
                        foreach ($live_ing as $key => $live) {
                    ?>
                        <li>
                            <i class="icon-circle"></i>
                            <!-- <a class="_video-url" target="_blank" href="javascript:void(0)" video-url="<?//= $live['live_url'].'&autoLogin=true&viewername='.$viewername.'&viewertoken='.$viewertoken ?>"> -->
                            <a class="_video-url" target="_blank" href="javascript:void(0)" video-url="<?= $live['live_url'] ?>">
                                <span class="top"><?= $live['start_time'] ?>-<?= $live['end_time'] ?></span>
                                <span class="bottom"><?= $live['course_name'] ?></span>
                            </a>
                        </li>
                    <?php
                        }
                    ?>
                    <?php
                        foreach ($live_will as $will_key => $will) {
                    ?>
                        <li>
                            <i class="icon-circle"></i>
                            <a target="_blank" href="<?= $will['live_url'].'&autoLogin=true&viewername='.$viewername.'&viewertoken='.$viewertoken ?>">
                                <span class="top"><?= $will['start_time'] ?>-<?= $will['end_time'] ?></span>
                                <span class="bottom"><?= $will['course_name'] ?></span>
                            </a>
                        </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="hot-section">
        <div class="container-course">
            <div class="course-hd">
                <h3 class="title">直属学院</h3>
                <div class="side">
                    <a href="<?= Url::to(['course/college']) ?>" class="link more">更多&gt;&gt;</a>
                </div>
            </div>
            <ul class="list">
                <?php foreach ($colleges as $college) { ?>
                    <li>
                        <a href="<?= Url::to(['course/college','cat' => $college->id]) ?>">
                            <i class="icon"><img src="<?= $college->list_icon; ?>"></i>
                            <h3><?= $college->name; ?></h3>
                            <div class="into"><span class="btn-into">进入学院</span></div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-course course-online">
        <div class="container-course-wrap">
            <div class="course-hd">
                <h3 class="course-title">热门课程</h3>
                <div class="side">
                    <a href="<?= Url::to(['course/list']) ?>" class="link more">更多&gt;&gt;</a>
                </div>
            </div>
            <div class="course-content">
                <ul class="list active">
                    <?php foreach ($hotcourses as $hotcourse) { ?>
                        <li>
                            <a href="<?= Url::to(['course/detail', 'courseid' => $hotcourse->id]) ?>">
                                <div class="course-img">
                                    <img class="course-pic" src="<?= $hotcourse->list_pic; ?>"/>
                                    <div class="course-statistic">
                                        <i class="icon ion-android-person"></i>
                                        <span class="people"><?= $hotcourse->online; ?>人在学</span>
                                        <i class="icon ion-heart"></i>
                                        <span class="course-price"><?= $hotcourse->collection; ?>人</span>
                                    </div>
                                </div>
                            </a>
                            <div class="teacher-section hot-course">
                                <!-- <img src="<?= User::getUserModel($hotcourse->teacher_id)->picture; ?>"/> -->
                                <span class="content-title teacher-name"><?= $hotcourse->course_name; ?></span>
                                <span class="content-title teacher-position"><?= CourseCategory::getNames($hotcourse->category_name); ?></span>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <?php 
        foreach ($collegeArr as $key => $college) {
            if (!empty($college['college_course']) && count($college['college_course']) != 0) { ?>
                <div class="container-course course-online college-wrap">
                    <div class="container-course-wrap">
                        <div class="course-hd">
                            <h3 class="course-title"><?= $college['college_name'] ?></h3>
                            <div class="side">
                                <a href="<?= Url::to(['course/college','cat' => $key]) ?>" class="link more">更多&gt;&gt;</a>
                            </div>
                        </div>
                        <div class="course-content">
                            <ul class="list active">
                                <?php 
                                    if (!empty($college['college_course'])) {
                                        foreach ($college['college_course'] as $course) { ?>
                                        <li>
                                            <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>">
                                                <div class="course-img">
                                                    <img class="course-pic" src="<?= $course->list_pic; ?>"/>
                                                </div>
                                                <p class="content-title"><?= $course->course_name; ?></p>
                                            </a>
                                            <!-- <div class="course-statistic">
                                                <i class="icon ion-android-person"></i>
                                                <span class="people"><?= $course->online; ?>人在学</span>
                                                <i class="icon ion-heart"></i>
                                                <span class="people"><?= $course->collection; ?>人</span>
                                            </div> -->
                                            <div class="teacher-section">
                                                <!-- <img src="<?= User::getUserModel($course->teacher_id)->picture; ?>"/> -->
                                                <span class="teacher-name">主讲人：<?= User::item($course->teacher_id); ?></span>
                                                <span class="teacher-position"><?= User::getUserModel($course->teacher_id)->description; ?></span>
                                            </div>
                                        </li>
                                        <?php }
                                    } ?>
                            </ul>
                        </div>
                    </div>
                </div>
        <?php }
        }
    ?>
    <div class="container-course teacher-section">
        <h3 class="course-title">教师风采</h3>
        <ul class="teach-list">
            <?php 
                $count = 0;
                foreach ($teachers as $key => $teacher) { 
                    if ($count === 10) {
                        break;
                    }
            ?>
                    <li>
                        <img class="people-img" src="<?= $teacher->picture; ?>"/>
                        <p class="intro">
                            <span class="name"><?= $teacher->username; ?></span>
                            <span class="work"><?= $teacher->office; ?></span>
                        </p>
                        <p class="intro">
                            <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                            <span class="te-text"><?= $teacher->unit; ?></span>
                        </p>
                        <p class="intro">
                            <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                            <span class="te-text"><?= $teacher->goodat; ?></span>
                        </p>
                    </li>
            <?php 
                $count = $count+1;
            } ?>
        </ul>
        <div class="clear"></div>
        <a href="<?= Url::to(['teacher/list']) ?>" class="view-more">查看更多</a>
    </div>
    <div class="cooperation-section">
        <div class="container-course">
            <ul class="course-tab">
                <li class="active">学习感言</li>
                <li>友情链接</li>
            </ul>
            <div class="course-content">
                <ul class="list user-comment active">
                    <?php 
                        foreach ($coments as $key => $coment) { ?>
                            <li>
                                <img src="<?= User::getUserModel($coment->user_id)->picture; ?>" class="user-img"/>
                                <div class="right-txt">
                                    <span class="user-name"><?= User::item($coment->user_id); ?></span>
                                    <p class="user-txt"><?= $coment->content; ?></p>
                                </div>
                            </li>
                    <?php } ?>
                </ul>
                <ul class="list link-section">
                    <?php 
                        foreach ($flinks as $key => $flink) { ?>
                            <li><a target="_blank" href="<?= $flink->src; ?>"><?= $flink->title; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?php echo Url::to('@web/js/index.js');?>"></script>