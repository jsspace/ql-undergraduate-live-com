<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;

AppAsset::addCss($this,'@web/css/index.css');

$this->title = 'My Yii Application';

$weekarray=array("日","一","二","三","四","五","六"); 

?>
<div class="site-index">
    <div class="live-course">
        <div class="live-course-container">
            <div class="left-video">
                <img src="/img/no-video.jpg" class="no-video"/>
                <a href="javascript:void(0)" class="enter-video-btn _video-btn" target="_blank">进入教室</a>
            </div>
            <div class="right-list">
                <div class="data-title">
                    <span class="time"><?= date("m").'月'.date("d").'日' ?>&nbsp;&nbsp;<?= '星期'.$weekarray[date("w")] ?></span>
                </div>
                <?php
                    $viewername = '';
                    $viewertoken = '';
                    if (!Yii::$app->user->isGuest) {
                    $viewername = User::getUserModel(Yii::$app->user->id)->username;
                    $viewertoken = User::getUserModel(Yii::$app->user->id)->password_hash;
                } ?>
                <ul class="video-title-list _video-list">
                    <?php
                        foreach ($live_ing as $key => $live) {
                    ?>
                        <li>
                            <i class="icon-circle"></i>
                            <a class="_video-url" target="_blank" href="javascript:void(0)" video-url="<?= $live['live_url'].'&autoLogin=true&viewername='.$viewername.'&viewertoken='.$viewertoken ?>">
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
                <h3 class="title">热门分类</h3>
                <div class="side">
                    <a href="<?= Url::to(['course/list']) ?>" class="link more">更多&gt;&gt;</a>
                </div>
            </div>
            <ul class="list">
                <?php foreach ($hotcats as $hotcat) { ?>
                    <li style="background-color: <?= $hotcat->backgroundcolor; ?>">
                        <a href="<?= Url::to(['course/list','cat' => $hotcat->categoryid]) ?>">
                            <i class="icon"><img src="<?= $hotcat->icon; ?>"></i>
                            <h3><?= $hotcat->title; ?></h3>
                            <div class="into"><span class="btn-into">进入科目</span></div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-course course-section">
        <h3 class="course-title">课程套餐</h3>
        <fieldset>
            <legend>
                <img src="/img/arrow-icon.jpg"/>
            </legend>
        </fieldset>
        <ul class="course-tab">
            <li class="active">热门课程</li>
            <li>最新课程</li>
            <li>课程排行</li>
        </ul>
        <div class="course-content">
            <ul class="list active">
                <?php foreach ($hotpcourses as $hotpcourse) { ?>
                    <li>
                        <a href="<?= Url::to(['package/detail', 'pid' => $hotpcourse->id]) ?>">
                            <div class="course-img">
                                    <img src="<?= $hotpcourse->list_pic; ?>"/>
                            </div>
                            <p class="content-title"><?= $hotpcourse->name; ?></p>
                        </a>
                        <div class="course-statistic">
                            <i class="icon ion-android-person"></i>
                            <span class="people"><?= $hotpcourse->online; ?>人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people"><?= $hotpcourse->collection; ?>人</span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <ul class="list">
                <?php foreach ($newpcourses as $newpcourse) { ?>
                    <li>
                        <a href="<?= Url::to(['package/detail', 'pid' => $newpcourse->id]) ?>">
                            <div class="course-img">
                                <img src="<?= $newpcourse->list_pic; ?>"/>
                            </div>
                            <p class="content-title"><?= $newpcourse->name; ?></p>
                        </a>
                        <div class="course-statistic">
                            <i class="icon ion-android-person"></i>
                            <span class="people"><?= $newpcourse->online; ?>人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people"><?= $hotpcourse->collection; ?>人</span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <ul class="list">
                <?php foreach ($rankpcourses as $rankpcourse) { ?>
                    <li>
                        <a href="<?= Url::to(['package/detail', 'pid' => $rankpcourse->id]) ?>">
                            <div class="course-img">
                                <img src="<?= $rankpcourse->list_pic; ?>"/>
                            </div>
                            <p class="content-title"><?= $rankpcourse->name; ?></p>
                        </a>
                        <div class="course-statistic">
                            <i class="icon ion-android-person"></i>
                            <span class="people"><?= $rankpcourse->online; ?>人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people"><?= $hotpcourse->collection; ?>人</span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <a href="<?= Url::to(['package/list']) ?>" class="view-more">查看更多</a>
    </div>
    <div class="container-course course-online">
        <h3 class="course-title">在线课程</h3>
        <fieldset>
            <legend>
                <img src="/img/arrow-icon.jpg"/>
            </legend>
        </fieldset>
        <ul class="course-tab">
            <li class="active">热门课程</li>
            <li>最新课程</li>
            <li>课程排行</li>
        </ul>
        <div class="course-content">
            <ul class="list active">
                <?php foreach ($hotcourses as $hotcourse) { ?>
                    <li>
                        <a href="<?= Url::to(['course/detail', 'courseid' => $hotcourse->id]) ?>">
                            <div class="course-img">
                                <img class="course-pic" src="<?= $hotcourse->list_pic; ?>"/>
                            </div>
                            <p class="content-title"><?= $hotcourse->course_name; ?></p>
                        </a>
                        <div class="course-statistic">
                            <i class="icon ion-android-person"></i>
                            <span class="people"><?= $hotcourse->online; ?>人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people"><?= $hotcourse->collection; ?>人</span>
                        </div>
                        <div class="teacher-section">
                            <img src="<?= User::getUserModel($hotcourse->teacher_id)->picture; ?>"/>
                            <span class="teacher-name"><?= User::item($hotcourse->teacher_id); ?></span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <ul class="list">
                <?php foreach ($newcourses as $newcourse) { ?>
                    <li>
                        <a href="<?= Url::to(['course/detail', 'courseid' => $newcourse->id]) ?>">
                            <div class="course-img">
                                <img class="course-pic" src="<?= $newcourse->list_pic; ?>"/>
                            </div>
                            <p class="content-title"><?= $newcourse->course_name; ?></p>
                        </a>
                        <div class="course-statistic">
                            <i class="icon ion-android-person"></i>
                            <span class="people"><?= $newcourse->online; ?>人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people"><?= $newcourse->collection; ?>人</span>
                        </div>
                        <div class="teacher-section">
                            <img src="<?= User::getUserModel($newcourse->teacher_id)->picture; ?>"/>
                            <span class="teacher-name"><?= User::item($newcourse->teacher_id); ?></span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <ul class="list">
                <?php foreach ($rankcourses as $rankcourse) { ?>
                    <li>
                        <a href="<?= Url::to(['course/detail', 'courseid' => $rankcourse->id]) ?>">
                            <div class="course-img">
                                <img class="course-pic" src="<?= $rankcourse->list_pic; ?>"/>
                            </div>
                            <p class="content-title"><?= $rankcourse->course_name; ?></p>
                        </a>
                        <div class="course-statistic">
                            <i class="icon ion-android-person"></i>
                            <span class="people"><?= $rankcourse->online; ?>人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people"><?= $rankcourse->collection; ?>人</span>
                        </div>
                        <div class="teacher-section">
                            <img src="<?= User::getUserModel($rankcourse->teacher_id)->picture; ?>"/>
                            <span class="teacher-name"><?= User::item($rankcourse->teacher_id); ?></span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <a href="<?= Url::to(['course/list']) ?>" class="view-more">查看更多</a>
    </div>
    <!-- <div class="ads-section">
        <div class="ads-bar">
            <div class="container-course">
                <div class="md-bar-tit">
                    <div class="t1">截止目前</div><div class="t2">注册学员数量</div>
                </div>
                <div class="bar-box">
                    <div class="bar-number">143</div>
                    <div class="bar-text">报名学员</div>
                    <div class="bar-postion">位</div>
                </div>
                <div class="bar-box">
                    <div class="bar-number">106</div>
                    <div class="bar-text">合作机构</div>
                    <div class="bar-postion">家</div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="container-course teacher-section">
        <h3 class="course-title">讲师团队</h3>
        <fieldset>
            <legend>
                <img src="/img/arrow-icon.jpg"/>
            </legend>
        </fieldset>
        <ul class="teach-list">
            <?php 
                foreach ($teachers as $key => $teacher) { ?>
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
            <?php } ?>
        </ul>
        <a href="<?= Url::to(['teacher/list']) ?>" class="view-more">查看更多</a>
    </div>
    <div class="container-course course-data">
        <h3 class="course-title">考本资料</h3>
        <fieldset>
            <legend>
                <img src="/img/arrow-icon.jpg"/>
            </legend>
        </fieldset>
        <div class="course-content">
            <ul class="list active">
                <?php foreach ($course_datas as $key => $course_data) { ?>
                    <li>
                        <img class="course-data-img" src="<?= $course_data->list_pic ?>"/>
                        <div class="right-con">
                            <p class="data-title">
                                <span class="data-label">考本必读</span>
                                <?php if ($course_data->url_type == 1) {
                                    $url = Url::to(['data/detail', 'dataid' => $course_data->id]);
                                    $target = '_self';
                                } else { 
                                    $url = strip_tags($course_data->content);
                                    $target = '_blank';
                                } ?>
                                <span><a target="<?= $target ?>" href="<?= $url ?>"><?= $course_data->name ?></a></span>
                            </p>
                            <p class="data-intro"><?= $course_data->summary ?></p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <div class="course-content-more">
                <a href="<?= Url::to(['data/list']) ?>" class="data-more-link">更多&gt;&gt;</a>
            </div>
        </div>
        <div class="course-referral">
            <h4 class="referral-title">课程推荐</h4>
            <div class="referral-content">
                <div class="top-section">
                    <img src="/img/referral-top.jpg"/>
                </div>
                <ul class="referral-list">
                    <?php 
                        foreach ($tjcourses as $key => $tjcourse) { ?>
                             <li>
                                <a href="<?= Url::to(['course-news/detail', 'newsid' => $tjcourse->id]) ?>"><span class="announce-title"><i></i><?= $tjcourse->title; ?></span></a>
                                <span class="announce-time"><?= date('Y-m-d', $tjcourse->create_time); ?></span>
                            </li>
                    <?php } ?>
                    <a href="<?= Url::to(['course-news/list']) ?>" class="more-link">更多&gt;&gt;</a>
                </ul>
            </div>
        </div>
    </div>
    <div class="cooperation-section">
        <div class="container-course">
            <!-- <h3 class="course-title">合作伙伴</h3> -->
            <!-- <fieldset>
                <legend>
                    <img src="/img/arrow-icon.jpg"/>
                </legend>
            </fieldset>
            <ul class="cooperation-list">
                <li class="cctv">
                    <img src="/img/cooperation-cctv.jpg"/>
                </li>
                <li class="kindon">
                    <img src="/img/cooperation-kindon.jpg"/>
                </li>
                <li class="anming">
                    <img src="/img/cooperation-anming.jpg"/>
                </li>
                <li class="xingye">
                    <img src="/img/cooperation-xingye.jpg"/>
                </li>
                <li class="juice">
                    <img src="/img/cooperation-juice.jpg"/>
                </li>
                <li class="ali">
                    <img src="/img/cooperation-ali.jpg"/>
                </li>
                <li class="china">
                    <img src="/img/cooperation-china.jpg"/>
                </li>
                <li class="construction">
                    <img src="/img/cooperation-construction.jpg"/>
                </li>
                <li class="jd">
                    <img src="/img/cooperation-jd.jpg"/>
                </li>
                <li class="vivo">
                    <img src="/img/cooperation-vivo.jpg"/>
                </li>
            </ul> -->
            <ul class="course-tab">
                <li class="active">用户评说</li>
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