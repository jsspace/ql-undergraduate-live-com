<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
</div>
<div class="user-wrapper">
    <div class="left-menu">
        <div class="topinfo">
            <img src="<?= Url::to('@web/'.Yii::$app->user->identity->picture); ?>" class="pic">
            <h4 class="name"><?= Yii::$app->user->identity->username; ?></h4>
            <p class="company">所属企业：<a href="" target="_blank"><?= Yii::$app->user->identity->unit; ?></a></p>
            <div class="btn">
                <a href="<?= Url::to(['user/info']) ?>"><i class="icon ion-ios-person-outline"></i>个人资料</a>
                <a href="<?= Url::to(['site/request-password-reset']) ?>"><i class="icon ion-edit"></i>修改密码</a>
            </div>
        </div>
        <div class="menu">
            <a href="<?= Url::to(['user']) ?>" class="a1 "><i class="icon ion-ios-book-outline"></i>我的课程</a>
            <a href="<?= Url::to(['user/orders']) ?>" class="a4 "><i class="icon ion-clipboard"></i>我的收藏</a>
            <a href="<?= Url::to(['user/orders']) ?>" class="a4 "><i class="icon ion-clipboard"></i>我的订单</a>
            <a href="<?= Url::to(['user/teacherreviews']) ?>"><i class="icon ion-ios-star-outline"></i>教师评价</a>
            <a href="<?= Url::to(['user/qnas']) ?>"><i class="icon ion-ios-help-outline"></i>我的提问</a>
            <a href="<?= Url::to(['user/coursereviews']) ?>"><i class="icon ion-ios-star-outline"></i>课程评价</a>
        </div>
    </div>
    <div class="right-content">
        <div class="info-wrapper">
            <p class="info-img">
                <span class="info-label">头像：</span>
                <span class="info-txt"><img src="<?= Url::to('@web/'.Yii::$app->user->identity->picture); ?>"/></span>
            </p>
            <p class="info-name">
                <span class="info-label">姓名：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->username; ?></span>
            </p>
            <p class="info-phone">
                <span class="info-label">电话：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->phone; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">邮箱：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->email; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">性别：</span>
                <span class="info-txt"><?php echo Yii::$app->user->identity->gender ? '女' : '男'; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">简短介绍：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->description; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">单位：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->unit; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">职务：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->office; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">擅长：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->goodat; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">介绍：</span>
                <span class="info-txt"><?= Yii::$app->user->identity->intro; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">会员码：</span>
                <span class="info-txt"><?= Yii::$app->user->id; ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">创建时间：</span>
                <span class="info-txt"><?php echo date('Y-m-d H:i:s',Yii::$app->user->identity->created_at); ?></span>
            </p>
            <p class="info-email">
                <span class="info-label">修改时间：</span>
                <span class="info-txt"><?php echo date('Y-m-d H:i:s',Yii::$app->user->identity->updated_at); ?></span>
            </p>
            <p class="info-btn">
                <a href="<?= Url::to(['user/edit']); ?>" class="edit-btn">修改</a>
            </p>
        </div>
    </div>
</div>