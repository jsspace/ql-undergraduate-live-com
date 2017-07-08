<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
    <div class="header">
        <a class="left-logo" href="/">
            <span class="logo-more">媒体淘课</span>
        </a>
        <nav class="header-menu">
            <a href="javascript:void(0)" class="menu-icon">
                <i class="icon ion-navicon"></i>
            </a>
            <ul class="account-con">
                <li class="account">
                    <a class="user-info">
                        <img src="/img/user.jpg" class="user-img" />
                        <span class="user-name">admin</span>
                    </a>
                    <div class="account-dropdown">
                        <div class="user-header">
                            <img src="/img/user.jpg"/>
                            <span class="user-manage">超级管理员</span>
                            <span class="user-login-time">上次登录 2017-06-23 15:25:34</span>
                        </div>
                        <div class="btn-wrapper">
                            <a href="" class="btn-default btn-modify">修改密码</a>
                            <a href="" class="btn-default btn-logout">退出登录</a>
                        </div>
                    </div>
                </li>
                <li class="notice-con">
                    <a href="">
                        <i class="icon ion-android-notifications-none"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="side-nav" id="tree">
    </div>
    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">Copyright &copy; <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
