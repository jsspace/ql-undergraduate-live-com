<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/teacher.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span><a href="/teacher/list">讲师列表</a></span>
    <span>&gt;</span>
    <span>韩大牛</span>
</div>
<div class="container-course teacher-detail">
    <div class="left-introduce">
        <p class="teacher-img"><img src="/img/teacher-people.png"/></p>
        <div class="teacher-name">
            <span class="name">韩大牛</span>
            <span class="school">中国传媒大学计算机科技</span>
        </div>
        <div class="star">
            <img src="/img/star-on.png"/>
            <img src="/img/star-on.png"/>
            <img src="/img/star-on.png"/>
            <img src="/img/star-on.png"/>
            <img src="/img/star-off.png"/>
        </div>
        <p class="teacher-class">
            <span class="tag">约课次数：</span>
            <span class="tag-count">0 次</span>
        </p>
        <p class="teacher-class">
            <span class="tag">课酬标准：</span>
            <span class="tag-count">面议</span>
        </p>
    </div>
    <div class="right-introduce">
        <h4>方毅华  中国传媒大学教授博士生导师</h4>
        <div class="txt">
            <h5>资历介绍</h5>
            <p></p><p>方毅华，中国传媒大学新闻传播学院教授，新闻业务教研室主任，博士生导师。先后在新疆人民广播电台、山西人民广播电台任记者、编辑。期间发表大量新闻作品并多次获得省级、中央级奖励。发表若干学术论文并参与主编《中国优秀广播作品文选》一书。</p>
            <h5>主讲课程</h5>
            <p>《节目构思与编排》&nbsp;《节目构思与分析》&nbsp;</p>
        </div>
    </div>
</div>
<ul class="container-course course-tab">
    <li class="active">网课</li>
    <li>面授课</li>
    <li>直播课</li>
</ul>
<div class="container-course course-content">
    <ul class="list active">
        <li>
            <div class="course-img">
                <img src="/img/course-list-img.jpg"/>
            </div>
            <p class="content-title">课程名称课程名称课程名称课程名称</p>
            <div class="course-statistic">
                <i class="icon ion-android-person"></i>
                <span class="people">11101人在学</span>
                <i class="icon ion-heart"></i>
                <span class="people">2345人</span>
            </div>
            <div class="teacher-section">
                <img src="/img/teacher-icon.jpg"/>
                <span class="teacher-name">张老师</span>
            </div>
        </li>
        <li>
            <div class="course-img">
                <img src="/img/course-list-img.jpg"/>
            </div>
            <p class="content-title">课程名称课程名称课程名称课程名称</p>
            <div class="course-statistic">
                <i class="icon ion-android-person"></i>
                <span class="people">11101人在学</span>
                <i class="icon ion-heart"></i>
                <span class="people">2345人</span>
            </div>
            <div class="teacher-section">
                <img src="/img/teacher-icon.jpg"/>
                <span class="teacher-name">张老师</span>
            </div>
        </li>
        <li>
            <div class="course-img">
                <img src="/img/course-list-img.jpg"/>
            </div>
            <p class="content-title">课程名称课程名称课程名称课程名称</p>
            <div class="course-statistic">
                <i class="icon ion-android-person"></i>
                <span class="people">11101人在学</span>
                <i class="icon ion-heart"></i>
                <span class="people">2345人</span>
            </div>
            <div class="teacher-section">
                <img src="/img/teacher-icon.jpg"/>
                <span class="teacher-name">张老师</span>
            </div>
        </li>
        <li>
            <div class="course-img">
                <img src="/img/course-list-img.jpg"/>
            </div>
            <p class="content-title">课程名称课程名称课程名称课程名称</p>
            <div class="course-statistic">
                <i class="icon ion-android-person"></i>
                <span class="people">11101人在学</span>
                <i class="icon ion-heart"></i>
                <span class="people">2345人</span>
            </div>
            <div class="teacher-section">
                <img src="/img/teacher-icon.jpg"/>
                <span class="teacher-name">张老师</span>
            </div>
        </li>
    </ul>
    <ul class="list">
    </ul>
    <ul class="list">
    </ul>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?php echo Url::to('@web/js/detail.js');?>"></script>