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
            <span class="topli">
                <img src="/images/topicon1.png" />微信公众号
            </span>
            <span class="topli">
                <img src="/images/topicon2.png" />电话号码
            </span>
            <?php if(Yii::$app->user->isGuest) {?>
            <span>
                <a href="<?= Url::to(['site/login']) ?>"><img src="/images/topicon3.png" />登录</a>
            </span>
            <span>没有账号？
                <a href="<?= Url::to(['site/signup']) ?>" class="topcol2">请注册！</a>
                <a href="<?= Url::to(['site/signup']) ?>" class="topcol2">申请试听</a>
            </span>
            <?php } else { ?>
                <span>你好，
                    <a href="<?= Url::to(['user/info']) ?>" class="topcol2 username"><?= Yii::$app->user->identity->username || '尊敬的用户' ?></a>
                    <a href="<?= Url::to(['user/info']) ?>" class="topcol2">会员中心</a>
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
    <h1><a href="#"><img src="/images/logo.png" /></a></h1>
</div>
<div id="topmenu">
    <dl>
        <dt>
            <ul class="colorfff">
                <li><a href="/">首页</a></li>
                <li><a href="/course/list">热门班级</a></li>
                <li><a href="/course/open">公开课</a></li>
                <li><a href="/teacher/intro">教师团队</a></li>
                <li><a href="#">如何上课</a></li>
                <li><a href="#">问老师</a></li>
            </ul>
        </dt>
        <dd>
            <input name="" type="text" class="topinput1" placeholder="请输入……" />
            <input name="" type="submit" class="topbtn1" />
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
                <p><a href="#">首   页</a></p>
                <p><a href="#">热门班级</a></p>
                <p><a href="#">公开课</a></p>
                <p><a href="#">教师团队</a></p>
                <p><a href="#">如何上课</a></p>
            </li>
            <li>
                <h4>快速链接</h4>
                <p><a href="#">帮助一</a></p>
                <p><a href="#">帮助二</a></p>
                <p><a href="#">测试一下</a></p>
                <p><a href="#">如何上课</a></p>
            </li>
            <li>
                <h4>联系地址</h4>
                <p>加盟热线：010-65000963</p>
                <p>督学邮箱：president@126.com</p>
            </li>
            <li class="ftwx">
                <span>
                <h4>官方微信</h4>
                <p><img src="/images/wxpic1.jpg" /></p>
            </span>
                <span>
                <h4>微信客服</h4>
                <p><img src="/images/wxpic1.jpg" /></p>
            </span>
            </li>
        </ul>
    </div>
    <div class="footer-bottom">Copyright©2018 优师联网络培训平台 2017 浙ICP备：16003173号</div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
