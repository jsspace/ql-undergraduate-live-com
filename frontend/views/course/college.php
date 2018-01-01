<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\CourseCategory;

AppAsset::addCss($this,'@web/css/college.css');

$this->title = 'My Yii Application';
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
                    <li class="<?php if ($all_college->id === $collegeArr['college']->id) echo 'active' ?>"><?= $all_college->name ?></li>
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
                    <span>师资力量</span>
                </li>
            </ul>
            <ul class="college-category-con _college-category-con">
                <li class="college-intro">
                    <?= $collegeArr['college']->des ?>
                </li>
                <li class="college-class active">
                    <?php foreach ($collegeArr["college_course"] as $key => $course) { ?>
                        <div class="user-course-list">
                            <div class="course-list-con">
                                <a href="" class="user-course-img"><img src="/img/course-list-img.jpg"/></a>
                                <div class="user-course-details">
                                    <h3><a href="" title="" target="_blank">健康养生</a></h3>
                                    <div class="row">主讲老师: 张老师</div>
                                    <div class="row">
                                        <div class="btns">
                                            <a class="btn btn-primary" target="_blank" href="">进入学习</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </li>
                <li class="teacher-section">
                    <div class="teach-list">
                        <div class="teacher-con">
                            <a href="">
                                <img class="people-img" src="/img/teacher-people.png"/>
                                <p class="intro">
                                    <span class="name">张老师</span>
                                    <span class="work">中国人民大学教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                                    <span class="te-text">中国人民大学</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">职称职务:&nbsp;&nbsp;</span>
                                    <span class="te-text">教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                    <span class="te-text">人类健康</span>
                                </p>
                            </a>
                        </div>
                        <div class="teacher-con">
                            <a href="">
                                <img class="people-img" src="/img/teacher-people.png"/>
                                <p class="intro">
                                    <span class="name">张老师</span>
                                    <span class="work">中国人民大学教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                                    <span class="te-text">中国人民大学</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">职称职务:&nbsp;&nbsp;</span>
                                    <span class="te-text">教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                    <span class="te-text">人类健康</span>
                                </p>
                            </a>
                        </div>
                        <div class="teacher-con">
                            <a href="">
                                <img class="people-img" src="/img/teacher-people.png"/>
                                <p class="intro">
                                    <span class="name">张老师</span>
                                    <span class="work">中国人民大学教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                                    <span class="te-text">中国人民大学</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">职称职务:&nbsp;&nbsp;</span>
                                    <span class="te-text">教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                    <span class="te-text">人类健康</span>
                                </p>
                            </a>
                        </div>
                        <div class="teacher-con">
                            <a href="">
                                <img class="people-img" src="/img/teacher-people.png"/>
                                <p class="intro">
                                    <span class="name">张老师</span>
                                    <span class="work">中国人民大学教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                                    <span class="te-text">中国人民大学</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">职称职务:&nbsp;&nbsp;</span>
                                    <span class="te-text">教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                    <span class="te-text">人类健康</span>
                                </p>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="/js/course-list.js"></script>