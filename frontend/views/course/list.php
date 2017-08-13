<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/course.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span>课程列表</span>
</div>
<div class="container-course course-section">
    <div class="course-category">
        <div class="category-title">分类&gt;&gt;</div>
        <ul class="category-li">
            <li>
                <a href="">全部</a>
            </li>
            <li>
                <a href="">文学类</a>
            </li>
            <li>
                <a href="">商务英语</a>
            </li>
            <li>
                <a href="">前端开发</a>
            </li>
            <li>
                <a href="">后端开发</a>
            </li>
            <li>
                <a href="">电视媒体</a>
            </li>
            <li>
                <a href="">天文地理</a>
            </li>
            <li>
                <a href="">化学生物</a>
            </li>
            <li>
                <a href="">前端开发</a>
            </li>
            <li>
                <a href="">后端开发</a>
            </li>
            <li>
                <a href="">电视媒体</a>
            </li>
            <li>
                <a href="">天文地理</a>
            </li>
            <li>
                <a href="">化学生物</a>
            </li>
        </ul>
    </div>
    <div class="course-content">
        <ul class="list active">
            <li>
                <div class="course-img">
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
            <li>
                <div class="course-img">
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
                </div>
                <p class="content-title">课程名称课程名称课程名称课程名称b</p>
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
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
            <li>
                <div class="course-img">
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
                </div>
                <p class="content-title">课程名称课程名称课程名称课程名称c</p>
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
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
                    <img class="course-pic" src="/img/course-list-img.jpg"/>
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
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script>
    function imgAnimate() {
      var self = this;
      $(".course-content").each(function() {
          $(this).find("li").each(function() {
              $(this).find(".course-img").on("mouseover", function() {
                  $(this).addClass("active").parents("li").siblings("li").find(".course-img").removeClass("active");
              });
              $(this).find(".course-img").on("mouseout", function() {
                  $(this).removeClass("active");
              });
          });
      });
    }
    imgAnimate();
</script>