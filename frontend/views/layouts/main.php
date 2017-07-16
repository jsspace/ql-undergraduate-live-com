<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

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

<div class="wrap">
    <div class="header-wrapper">
        <div class="top-ads">
            <div class="ads">
                热烈祝贺***以全市最优异的成绩考上清华大学计算机专业
            </div>
            <ul class="log-sec no-login">
                <li class="register">注册</li>
                <li class="login">登录</li>
            </ul>
            <ul class="log-sec has-login">
                <li class="logout">
                    <i class="icon ion-log-out"></i>
                </li>
                <li class="login">
                    <i class="icon ion-android-person"></i>
                    <span class="user-name">哈哈</span>
                </li>
                <li class="cart">
                    <i class="icon ion-ios-cart-outline"></i>
                    <i class="cart-count">23</i>
                </li>
            </ul>
        </div>
        <div class="menu-wrapper">
            <div class="logo">
                <img src="/img/website-logo.jpg"/>
            </div>
            <ul class="nav-menu">
                <li>
                    <a href="">首页</a>
                </li>
                <li>
                    <a href="">课程</a>
                </li>
                <li>
                    <a href="">套餐</a>
                </li>
                <li>
                    <a href="">讲师团</a>
                </li>
                <li>
                    <a href="">资料</a>
                </li>
                <li>
                    <div class="search-section">
                        <input type="text" placeholder="输入课程名或讲师名进行搜索" />
                        <a href="javascript:void(0)" class="search-btn">搜索</a>
                    </div>
                </li>
            </ul>
            <div class="website-qrcode">
                <div class="qrcode">
                    <span class="label">官方微信</span>
                    <img src="/img/website-qrcode.jpg" class="code-img"/>
                </div>
                <div class="qrcode">
                    <span class="label">手机官网</span>
                    <img src="/img/mobile-qrcode.jpg" class="code-img"/>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer>
    <div class="footer">
        <div class="footer-inner">
            <dl>
                <dt>常见问题</dt>
                <dd><a href="">帮助一</a></dd>
                <dd><a href="">帮助二</a></dd>
                <dd><a href="">测试一下</a></dd>
                <dd><a href="">更多帮助</a></dd>
            </dl>
            <dl>
                <dt>合作共赢</dt>
                <dd><a href="">关于我们</a></dd>
                <dd><a href="">企业申请使用</a></dd>
                <dd><a href="">讲师合作等级</a></dd>
            </dl>
            <dl>
                <dt>联系我们</dt>
                <dd>咨询电话：400-888-3456</dd>
                <dd>全国加盟热线：010-88448888</dd>
                <dd>投诉电话：010-51608888</dd>
                <dd>校长邮箱：president@juren.com</dd>
            </dl>
            <dl class="qrcode-section">
                <dt>官方微信</dt>
                <dd><img src="/img/website-qrcode-large.jpg"/></dd>
            </dl>
            <dl class="qrcode-section">
                <dt>手机微信</dt>
                <dd><img src="/img/mobile-qrcode-large.jpg"/></dd>
            </dl>
        </div>
    </div>
    <div class="copyright">
        <p class="pull-left">&copy; 2015-<?= date('Y') ?>  企源力---京ICP备13020285号</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
