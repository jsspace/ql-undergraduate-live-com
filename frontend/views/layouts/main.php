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
                <img src=""/>
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
            </ul>
            <div class="search-section">
                <input type="text" />
                <a href="javascript:void(0)" class="search-btn">搜索</a>
            </div>
            <div class="website-qrcode">
                <div class="qrcode">
                    <span class="label">官方微信</span>
                    <img src="" class="code-img"/>
                </div>
                <div class="qrcode">
                    <span class="label">手机官网</span>
                    <img src="" class="code-img"/>
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

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
