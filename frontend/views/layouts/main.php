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
            <!-- <div class="ads">
                热烈祝贺***以全市最优异的成绩考上清华大学计算机专业
            </div> -->
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
        <div class="nav-login">
            <div class="inner">
            <?php if(Yii::$app->user->isGuest) {?>
            <ul class="log-sec no-login unlogin">
                <li class="login"><a href="<?= Url::to(['site/login']) ?>">请登录</a></li>
                <li class="register"><a href="<?= Url::to(['site/signup']) ?>">免费注册</a></li>
            </ul>
            <?php } else {
                echo '<ul class="log-sec login login-wrap"><li class="user-li user-avar"><a href="'.Url::to(["user/info"]).'"><img src="'
                    . Yii::$app->user->identity->picture . '"/>&nbsp;&nbsp;'.Yii::$app->user->identity->username.'</a></li><li class="logout-li">'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        '退出',
                        ['class' => 'logout-link']
                    )
                    . Html::endForm(). '</li></ul>';
            }?>

            <ul class="nav-right">
                <li>
                    <dl>
                        <dt class="nav-title"><a href="/user/info">个人中心</a></dt>
                        <div class="nav-show">
                            <dd><a href="/user/course">我的课程</a></dd>
                            <dd><a href="/user/coin">我的钱包</a></dd>
                            <dd><a href="/user/edit">个人设置</a></dd>
                            <dd><a href="/user/message">消息通知</a></dd>
                        </div>
                    </dl>
                </li>
                <li><a href="/cart/index" class="cart-link nav-title"><img src="/img/cart-icon.png" />我的购物车</a></li>
                <li><a href="/comment/index" class="nav-title">学习感言</a></li>
                <li><a href="/command/index" class="nav-title">课程需求</a></li>
            </ul>
            </div>
        </div>
        <div class="menu-wrapper">
            <div class="logo">
                <img src="/img/website-logo.png"/>
            </div>
            <ul class="nav-menu">
                <li>
                    <a href="/">首页</a>
                </li>
                <li>
                    <a href="/course/college">直属学院</a>
                </li>
                <li>
                    <a href="/course/list">新课提醒</a>
                </li>
                <li>
                    <a href="/teacher/list">教师风采</a>
                </li>
                <li>
                    <a href="/member/index">会员</a>
                </li>
                <li>
                    <a href="/card/index">学习卡充值</a>
                </li>
                <!-- <li>
                    <a href="/comment/index">学习感言</a>
                </li>
                <li>
                    <a href="/command/index">课程需求</a>
                </li> -->
            </ul>
            <div class="menu-search-group">
                <form action="<?= Url::to(['course/search']); ?>" method="get">
                    <button type="submit" class="glyphicon glyphicon-search search-button _search-button"></button>
                    <input type="text" class="form-control" placeholder="搜索课程" name="searchContent">
                </form>
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
                <dd>咨询电话：010-65000965</dd>
                <dd>全国加盟热线：010-65000965</dd>
                <dd>投诉电话：010-65000965</dd>
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
        <p class="pull-left">&copy; <?= date('Y') ?>  优师联网络培训平台---京ICP备17055689号-1</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
