<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use backend\models\Read;
use backend\models\Provinces;
use backend\models\Cities;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/htmain.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/css/user.css" type="text/css" media="screen" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="httop" class="colorfff cc">
    <h1><a href="/"><img src="/images/logo-user.png" /></a></h1>
    <ul>
        <li><a href="/about/timetable" target="_blank"><img src="/images/hticon1.png" />备考规划</a></li>
        <li><a href="/course/list" target="_blank"><img src="/images/hticon1a.png" />热门班级</a></li>
        <li><a href="/course/open" target="_blank"><img src="/images/hticon1b.png" />公开课</a></li>
        <li><a href="#"><img src="/images/hticon1c.png" />个人资料</a></li>
        <li><a href="/about/how-to-study" target="_blank"><img src="/images/hticon1d.png" />如何上课</a></li>
        <li><a href="/user/ask-teacher"><img src="/images/hticon1e.png" />直播答疑</a></li>
    </ul>
    <dl class="hear-right__bar">
        <dd class="hthome"><img src="/images/htpic1.png" width="60" height="60" /><span><p><a href="#"><?= Yii::$app->user->identity->username || '尊敬的用户' ?></a></p><p><a href="/">官网首页</a></p></span></dd>
        <dd class="htxx"><a href="/user/message"><img src="/images/hticon2.png" />消息<code>8</code></a></dd>
        <dd class="htexit"><a href="<?= Url::to(['site/logout']) ?>"><img src="/images/hticon2a.png" />退出</a></dd>
    </dl>
</div>
<div id="htbox">
    <div class="htsidebar">
        <h3 class="colorfff">个人中心</h3>
        <ul id="userNav">
            <li><a href="/user/course"><span><img src="/images/hticon3.png" /><cite><img src="/images/hticon3a.png" /></cite></span>我的班级</a></li>
            <li><a href="/user/orders"><span><img src="/images/hticon4.png" /><cite><img src="/images/hticon4a.png" /></cite></span>我的订单</a></li>
            <li><a href="/cart/index" target="_blank"><span><img src="/images/shopping.png" /><cite><img src="/images/shoppinga.png" /></cite></span>购物车</a></li>
            <li><a href="/user/favorite"><span><img src="/images/hticon6.png" /><cite><img src="/images/hticon6a.png" /></cite></span>我的收藏</a></li>
            <li><a href="/user/coupon"><span><img src="/images/hticon7.png" /><cite><img src="/images/hticon7a.png" /></cite></span>我的奖励</a></li>
            <li><a href="#"><span><img src="/images/hticon9.png" /><cite><img src="/images/hticon9a.png" /></cite></span>邀请好友</a></li>
        </ul>
        <dl>
            <!-- <dt>
                <h4><a href="/about/start-guid">开学指导</a></h4>
                <h4><a href="/about/student-book">学员手册</a></h4>
                <h5>常见问题</h5>
                <p><a href="/about/faq">?问题1</a></p>
                <p><a href="/about/faq">?问题2</a></p>
                <p><a href="/about/faq">?问题3</a></p>
            </dt> -->
            <dd>
                <h4><img src="/images/htwxicon1.png" />微信客服</h4>
                <p><img src="/images/kefu-erweima.jpg" /></p>
            </dd>
        </dl>
    </div>
    <div class="content">
        <?= $content ?>
    </div>
</div>
<script src="/js/jquery.js" type="text/javascript"></script>
<script>
    $(function () {
        function activeNav() {
            var pathname = location.pathname;
            var navLink = $('#userNav').find('a');
            navLink.each(function() {
                if ($(this).attr('href') === pathname) {
                    $(this).parents('li').addClass('htleftnow');
                }
            })
        }
        activeNav();
    })
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
