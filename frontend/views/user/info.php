<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
    </div>
</div>
<div class="user-wrapper">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <div class="info-wrapper">
            <p class="info-img">
                <span class="info-label">头像：</span>
                <span class="info-txt"><img src="<?= Yii::$app->user->identity->picture; ?>"/></span>
            </p>
            <p class="info-name">
                <span class="info-label">用户名：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->username; ?></span>
            </p>
            <p class="info-phone">
                <span class="info-label">电话：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->phone; ?></span>
            </p>
            <p class="info-phone">
                <span class="info-label">省份：</span>
                <span class="info-txt"><?= Provinces::item(Yii::$app->user->identity->provinceid) ?></span>
            </p>
            <p class="info-phone">
                <span class="info-label">地级市：</span>
                <span class="info-txt"><?= Cities::item(Yii::$app->user->identity->cityid) ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">邮箱：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->email; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">性别：</span>
                <span class="info-txt"><?php echo Yii::$app->user->identity->gender ? '女' : '男'; ?></span>
            </p>
            <!-- <p class="info-email">
                <span class="info-label">会员码：</span>
                <span class="info-txt"><?= Yii::$app->user->id; ?></span>
            </p> -->
            <p class="info-btn">
                <a href="<?= Url::to(['user/edit']); ?>" class="edit-btn">修改</a>
            </p>
        </div>
    </div>
</div>