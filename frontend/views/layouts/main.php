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

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="topnav">
    <dl class="color2">
        <dt>欢迎您来到都想学！</dt>
        <dd>
           <!-- <span class="topli wechat-icon-wrap hover">
                <img src="/images/cart-icon.png"/>购物车
                <img src="/images/public-erweima.jpg" class="erweima">
            </span>-->
            <!-- <span class="topli qq-icon-wrap hover">
                <img src="/images/topicon2.png" />qq
                <img src="/images/qq-erweima.jpg" class="erweima">
            </span> -->
            <?php if(Yii::$app->user->isGuest) {?>
            <span>
                <a href="<?= Url::to(['site/login']) ?>"><img src="/images/topicon3.png" />登录</a>
            </span>
            <span>没有账号？
                <a href="<?= Url::to(['site/signup']) ?>" class="topcol2">请注册！</a>
                <a href="<?= Url::to(['site/signup']) ?>" class="topcol2">申请试听</a>
            </span>
            <?php } else { ?>
                <span class="topli">
                    <a href="/cart/index"><img src="/images/cart-icon.png"/>购物车</a>
                </span>
                <span class="topli">你好，
                    <a href="<?= Url::to(['user/course']) ?>" class="topcol2 username"><?= Yii::$app->user->identity->username ? Yii::$app->user->identity->username : '尊敬的用户' ?></a>
                    <a href="<?= Url::to(['user/course']) ?>" class="topcol2">会员中心</a>
                </span>
                <span>
                    <a href="<?= Url::to(['site/logout']) ?>" class="topcol2">退出</a>
                </span>
            <?php } ?>
        </dd>
    </dl>
</div>
<div id="header" class="cc">
    <span>
        <img src="/images/topdh.png" />010-65000965<p>全国服务咨询热线</p>
    </span>
    <h1><a href="/"><img src="/images/logo.png" /></a></h1>
</div>
<div id="topmenu">
    <dl>
        <dt>
            <ul class="colorfff">
                <li><a href="/">首页</a></li>
                <li><a href="/package/list">套餐</a></li>
                <li><a href="/course/list">精品课</a></li>
                <li><a href="/course/open">公开课</a></li>
                <li><a href="/book/list">图书</a></li>
                <li><a href="/teacher/intro">教师团队</a></li>
                <li><a href="/about/how-to-study">如何上课</a></li>
                <li><a href="/information/list">升本资讯</a> </li>
            </ul>
        </dt>
        <dd>
            <form action="<?= Url::to(['course/search']); ?>" method="get">
                <button type="submit" class="topbtn1"></button>
                <input type="text" class="topinput1" placeholder="请输入……" autocomplete="off" name="searchContent" />
            </form>        
        </dd>
    </dl>
</div>
<div class="content">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<div id="footer">
    <div class="footer-content">
        <h2><img src="/images/ftlogo.png" /><p>优师联网络培训平台</p></h2>
        <ul>
            <li>
                <h4>快速链接</h4>
                <p><a href="/">首   页</a></p>
                <p><a href="/course/list">热门班级</a></p>
                <p><a href="/course/open">公开课</a></p>
                <p><a href="/teacher/intro">教师团队</a></p>
                <p><a href="/user/ask-teacher">问老师</a></p>
            </li>
            <li>
                <h4>快速链接</h4>
                <p><a href="/about/index">关于我们</a></p>
                <p><a href="/about/join">加入我们</a></p>
                <p><a href="/about/how-to-study">如何上课</a></p>
                <p><a href="/about/faq">常见问题</a></p>
            </li>
            <li>
                <h4>联系地址</h4>
                <p>服务热线：010-65000965</p>
                <p>督学邮箱：mengxg@cuc.edu.cn</p>
            </li>
            <li class="ftwx">
                <span>
                <h4>公众号微信</h4>
                <p><img src="/images/public-erweima.jpg" /></p>
            </span>
                <span>
                <h4>微信客服</h4>
                <p><img src="/images/kefu-erweima.jpg" /></p>
            </span>
            </li>
        </ul>
    </div>
    <div class="footer-bottom">Copyright©2018 优师联网络培训平台 2017 浙ICP备：16003173号</div>
</div>
<script type="text/javascript" src="https://2.molinsoft.com/jsCode?publishId=5b6a8670682f12d7016835129a29205f"></script><div class="xtsitelinkstyle"><a href="http://www.webkefu.com">在线客服系统</a></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
