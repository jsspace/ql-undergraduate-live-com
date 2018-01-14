<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

?>
<div class="left-menu">
    <div class="topinfo">
        <img src="<?= Url::to('@web/'.Yii::$app->user->identity->picture); ?>" class="pic">
        <h4 class="name"><?= Yii::$app->user->identity->username; ?></h4>
        <div class="btn">
            <a href="<?= Url::to(['user/info']) ?>"><i class="icon ion-ios-person-outline"></i>个人资料</a>
            <a href="<?= Url::to(['site/change-password']) ?>"><i class="icon ion-edit"></i>修改密码</a>
        </div>
    </div>
    <div class="menu">
        <a href="<?= Url::to(['user/course']) ?>" class="a1 "><i class="icon ion-ios-book-outline"></i>我的课程</a>
        <a href="<?= Url::to(['user/class']) ?>" class="a1 "><i class="icon ion-ios-book-outline"></i>班级会员</a>
        <a href="<?= Url::to(['user/favorite']) ?>" class="a4 "><i class="icon ion-ios-star-outline"></i>我的收藏</a>
        <a href="<?= Url::to(['user/orders']) ?>" class="a4 "><i class="icon ion-ios-list-outline"></i>我的订单</a>
        <a href="<?= Url::to(['user/qnas']) ?>"><i class="icon ion-ios-help-outline"></i>我的提问</a>
        <a href="<?= Url::to(['user/course-reviews']) ?>"><i class="icon ion-ios-chatboxes-outline"></i>课程评价</a>
        <a href="<?= Url::to(['user/coupon']) ?>"><i class="icon ion-ios-rose-outline"></i>我的优惠券</a>
        <a href="<?= Url::to(['user/coin']) ?>"><i class="icon ion-ios-rose-outline"></i>我的钱包</a>
        <a href="<?= Url::to(['user/member']) ?>"><i class="icon ion-ios-rose-outline"></i>我的会员</a>
    </div>
</div>