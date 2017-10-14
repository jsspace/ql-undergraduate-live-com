<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;

AppAsset::addCss($this,'@web/css/course.css');

$this->title = 'My Yii Application';
?>
<?php
    $course = $courseDetail['course'];
    $cousechild = $courseDetail['coursechild'];
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span><a href="/course/list">课程列表</a></span>
    <span>&gt;</span>
    <span><?= $course->course_name; ?></span>
</div>
<div class="container-course course-detail-section">
    <div class="main-section">
        <div class="course-detail-left">
            <img src="<?= $course->home_pic; ?>"/>
        </div>
        <div class="course-detail-right">
            <div class="course-detail-title"><?= $course->course_name; ?></div>
            <div class="course-sub-title"><?= $course->course_name; ?></div>
            <div class="course-info">课程信息</div>
            <ul class="info-list">
                <li>
                    <img src="/img/tb_01.jpg"/>
                    <span>主讲&nbsp;&nbsp;<?= User::item($course->teacher_id); ?></span>
                </li>
                <li>
                    <img src="/img/tb_02.jpg"/>
                    <span>时长&nbsp;&nbsp;<?= $duration ?>分钟</span>
                </li>
                <li>
                    <img src="/img/tb_03.jpg"/>
                    <span>课时&nbsp;&nbsp;<?= ceil($duration/60) ?></span>
                </li>
                <li>
                    <img src="/img/tb_04.jpg"/>
                    <span>浏览&nbsp;&nbsp;<?= $course->view ?></span>
                </li>
                <li>
                    <img src="/img/tb_05.jpg"/>
                    <span>分享&nbsp;&nbsp;<?= $course->share ?></span>
                </li>
                <li>
                    <img src="/img/tb_06.jpg"/>
                    <span>收藏&nbsp;&nbsp;<?= $course->collection ?></span>
                </li>
            </ul>
            <div class="share-like">
                <p class="share-list">
                    <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt" target="_blank">
                        <img src="/img/tb_07.jpg"/>
                        <span>分享</span>
                    </a>
                </p>
                <p class="share-list">
                    <img src="/img/tb_08.jpg"/>
                    <span>收藏</span>
                </p>
            </div>
            <div class="btn-course">
                <a class="add-cart" href="<?= Url::to(['order-info/cart']) ?>">我要报名</a>
            </div>
        </div>
    </div>
    <div class="main-section">
        <div class="kc-left">
            <ul class="course-tag">
                <li class="active">课程章节</li>
                <li>课程详情</li>
                <li>课程评价</li>
                <li>教师答疑</li>
                <li>课程资料</li>
            </ul>
            <div class="course-tag-content">
                <div class="tag-content active">
                    <ul class="chapter-title">
                        <?php foreach ($cousechild as $key => $chapter) { ?>
                            <li class="active">
                                <div class="chapter-title-name"><?= $chapter['chapter']->name ?></div>
                                <ul class="chapter-con">
                                    <?php foreach ($chapter['chapterchild'] as $key => $section) { ?>
                                    <li>
                                        <img src="/img/chapter-play-icon.png"/>
                                        <a href="" class="chapter-list-name"><?= $section->name ?></a>
                                        <div class="chapter-list-time">
                                            <span class="time-tag">直播回放</span>
                                            <span class="time-con">01:12:13</span>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="tag-content">
                    <?= $course->des; ?>
                </div>
                <div class="tag-content">
                    <ul class="evaluate-list">
                        <li>
                            <div class="user-info">
                                <p class="user-img"><img src="/img/teacher-people.png"/></p>
                                <p class="user-name">孤独的背影</p>
                            </div>
                            <div class="user-evaluate">
                                <p class="evaluate-info">总结到位，讲解清楚</p>
                                <p class="evaluate-time">2017-05-24 10:09:23</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tag-content">
                教师答疑
                </div>
                <div class="tag-content">
                课程资料
                </div>
            </div>
        </div>
        <div class="kc-right">
            <div class="teacher-show">
                <div class="teacher-img"><img src="<?= User::getUserModel($course->teacher_id)->picture; ?>"/></div>
                <div class="teacher-detail">
                    <span class="name">教师： <?= User::item($course->teacher_id); ?></span>
                    <a href="" class="view-btn">查看教师</a>
                </div>
                <div class="teacher-tag"><?= User::getUserModel($course->teacher_id)->description; ?></div>
            </div>
            <div class="teacher-info"><?= User::getUserModel($course->teacher_id)->intro; ?></div>
        </div>
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
<script>
    var jiathis_config={
        url: window.location.href,
        summary:"课程",
        title:"课程",
        shortUrl:false,
        hideMore:false
    };
    function tagTab() {
      var self = this;
      $(".course-tag li").each(function(index) {
          $(this).on("click", function() {
              $(this).addClass("active").siblings("li").removeClass("active");
              $(".course-tag-content .tag-content").eq(index).addClass("active").siblings(".tag-content").removeClass("active");
          });
      });
      $(".chapter-title li").each(function() {
          var $parentEle = $(this);
          $(this).find(".chapter-title-name").on("click", function() {
              if (!$parentEle.hasClass("active")) {
                  $parentEle.addClass("active");
              } else {
                  $parentEle.removeClass("active");
              }
          });
      });
    }
    tagTab();
</script>