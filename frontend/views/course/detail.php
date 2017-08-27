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
    <span><a href="/course/list">课程列表</a></span>
    <span>&gt;</span>
    <span>影视作品声音艺术的讲解与分析</span>
</div>
<div class="container-course course-detail-section">
    <div class="main-section">
        <div class="course-detail-left">
            <img src="/img/course-list-img.jpg"/>
        </div>
        <div class="course-detail-right">
            <div class="course-detail-title">影视作品声音艺术的讲解与分析</div>
            <div class="course-sub-title">影视作品声音艺术的讲解与分析</div>
            <div class="course-info">课程信息</div>
            <ul class="info-list">
                <li>
                    <img src="/img/tb_01.jpg"/>
                    <span>主讲&nbsp;&nbsp;张老师</span>
                </li>
                <li>
                    <img src="/img/tb_02.jpg"/>
                    <span>时长&nbsp;&nbsp;00:00:00</span>
                </li>
                <li>
                    <img src="/img/tb_03.jpg"/>
                    <span>课时&nbsp;&nbsp;0</span>
                </li>
                <li>
                    <img src="/img/tb_04.jpg"/>
                    <span>浏览&nbsp;&nbsp;55</span>
                </li>
                <li>
                    <img src="/img/tb_05.jpg"/>
                    <span>分享&nbsp;&nbsp;123</span>
                </li>
                <li>
                    <img src="/img/tb_06.jpg"/>
                    <span>收藏&nbsp;&nbsp;444</span>
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
                        <li class="active">
                            <div class="chapter-title-name">创新时代</div>
                            <ul class="chapter-con">
                                <li>
                                    <img src="/img/chapter-play-icon.png"/>
                                    <a href="" class="chapter-list-name">第一讲  突发性新闻事件</a>
                                    <div class="chapter-list-time">
                                        <span class="time-tag">直播回放</span>
                                        <span class="time-con">01:12:13</span>
                                    </div>
                                </li>
                                <li>
                                    <img src="/img/chapter-play-icon.png"/>
                                    <a href="" class="chapter-list-name">第一讲  突发性新闻事件</a>
                                    <div class="chapter-list-time">
                                        <span class="time-tag">直播回放</span>
                                        <span class="time-con">01:12:13</span>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div class="chapter-title-name">创新时代</div>
                            <ul class="chapter-con">
                                <li>
                                    <img src="/img/chapter-play-icon.png"/>
                                    <a href="" class="chapter-list-name">第一讲  突发性新闻事件</a>
                                    <div class="chapter-list-time">
                                        <span class="time-tag">直播回放</span>
                                        <span class="time-con">01:12:13</span>
                                    </div>
                                </li>
                                <li>
                                    <img src="/img/chapter-play-icon.png"/>
                                    <a href="" class="chapter-list-name">第一讲  突发性新闻事件</a>
                                    <div class="chapter-list-time">
                                        <span class="time-tag">直播回放</span>
                                        <span class="time-con">01:12:13</span>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="tag-content">
                    课程详情内容
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
                <div class="teacher-img"><img src="/img/teacher-people.png"/></div>
                <div class="teacher-detail">
                    <span class="name">教师： 张老师</span>
                    <a href="" class="view-btn">查看教师</a>
                </div>
                <div class="teacher-tag">中国人民大学教授</div>
            </div>
            <div class="teacher-info">郭艳民，中国传媒大学教授、硕士研究生导师。1997年毕业后留校任教至今，现任中国传媒大学新闻传播学部电视学院电视系摄影教研室主任。主要作品有大型专题片《让生命永存》、人物传纪片《吴冠中》、《黄文》、《蔡国强》等。主要著作有《摄影构图》、《电视新闻摄影理论及应用》、《新闻摄影》等。 </div>
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