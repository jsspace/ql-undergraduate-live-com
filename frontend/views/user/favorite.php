<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;
use backend\models\User;

AppAsset::addCss($this,'@web/css/user.css');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>个人中心</title>
    <meta name="description" content="个人中心"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="/css/htmain.css" type="text/css" media="screen"/>
</head>
<body>
<div id="httop" class="colorfff cc">
    <h1><a href="/"><img src="/images/htlogo.png"/></a></h1>
    <ul>
        <li><a href="#"><img src="/images/hticon1.png"/>我的课表</a></li>
        <li><a href="#"><img src="/images/hticon1a.png"/>热门班级</a></li>
        <li><a href="/course/open"><img src="/images/hticon1b.png"/>公开课</a></li>
        <li><a href="#"><img src="/images/hticon1c.png"/>个人资料</a></li>
        <li><a href="/about/how-to-study"><img src="/images/hticon1d.png"/>如何上课</a></li>
        <li><a href="#"><img src="/images/hticon1e.png"/>问老师</a></li>
    </ul>
    <dl>
        <dd class="hthome"><img src="/images/htpic1.png" width="60" height="60"/><span><p><a href="#"><?= Yii::$app->
            user->identity->username || '尊敬的用户' ?></a></p><p><a href="/">官网首页</a></p></span></dd>
        <dd class="htxx"><a href="/user/message"><img src="/images/hticon2.png"/>消息<code>8</code></a></dd>
        <dd class="htexit"><a href="<?= Url::to(['site/logout']) ?>"><img src="/images/hticon2a.png"/>退出</a></dd>
    </dl>
</div>
<div id="htbox">
    <div class="htsidebar">
        <h3 class="colorfff">个人中心</h3>
        <ul>
            <li><a href="/user/class"><span><img src="/images/hticon3.png"/><cite><img
                    src="/images/hticon3a.png"/></cite></span>我的班级</a></li>
            <li><a href="/user/orders"><span><img src="/images/hticon4.png"/><cite><img
                    src="/images/hticon4a.png"/></cite></span>我的订单</a></li>
            <li class="htleftnow"><a href="/user/favorite"><span><img src="/images/hticon6.png"/><cite><img
                    src="/images/hticon6a.png"/></cite></span>我的收藏</a></li>
            <li><a href="/user/coupon"><span><img src="/images/hticon7.png"/><cite><img
                    src="/images/hticon7a.png"/></cite></span>我的奖励</a></li>
            <li><a href="#"><span><img src="/images/hticon9.png"/><cite><img src="/images/hticon9a.png"/></cite></span>邀请好友</a>
            </li>
        </ul>
        <dl>
            <dt>
                <h4><a href="/about/start-guid">开学指导</a></h4>
                <h4><a href="/about/student-book">学员手册</a></h4>
                <h5>常见问题</h5>
                <p><a href="/about/faq">?问题1</a></p>
                <p><a href="/about/faq">?问题2</a></p>
                <p><a href="/about/faq">?问题3</a></p>
            </dt>
            <dd>
                <h4><img src="/images/htwxicon1.png"/>微信客服</h4>
                <p><img src="/images/kefu-erweima.jpg"/></p>
            </dd>
        </dl>
    </div>
    <div class="htcontent">
        <h2 class="htwx cc"><a href="/">首页</a>&gt;<a href="#">我的收藏</a></h2>
        <div class="htbox2">
            <div class="httxt1 cc">
                <h3 class="ht_tt1">我的收藏</h3>
                <ul class="user-course-list">
                    <?php foreach ($flist as $key => $course) { ?>
                    <li>
                        <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"
                           class="user-course-img"><img src="<?= $course->list_pic ?>"/></a>
                        <div class="user-course-details">
                            <h3><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"
                                   title="<?= $course->course_name ?>" target="_blank"><?= $course->course_name ?></a>
                            </h3>
                            <div class="row">主讲老师: <?= User::item($course->teacher_id); ?></div>
                            <div class="row">
                                <div class="btns">
                                    <a class="btn btn-primary _quick-buy" target="_blank" href="javascript:void(0);">立即购买</a>
                                    <input class="course-id _course-id" type="hidden" value="<?= $course->id; ?>"/>
                                    <a class="btn btn-default unfavorite _unfavorite" href="javascript:void(0);"
                                       data-id="<?= $course->id ?>" data-favor="1">取消收藏</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
                <?php if (count($flist) == 0) { ?>
                <div class="empty-content">您还没有收藏任何课程哦~赶紧去 <a href="/course/list" class="go-link">挑选课程&gt;&gt;</a></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        function qiehuan(qhan, qhshow, qhon) {
            $(qhan).click(function () {
                $(qhan).removeClass(qhon);
                $(this).addClass(qhon);
                var i = $(this).index(qhan);
                $(qhshow).eq(i).show().siblings(qhshow).hide();
            });
        }

        qiehuan(".httxt1 dd", ".httxt1 ul", "htqhnow");

        $(".httxt2_show dl dt").click(function () {
            $(".httxt2_show dl").removeClass("ktshow");
            $(this).parent().addClass("ktshow");
        })

    });
</script>
</body>
</html>
