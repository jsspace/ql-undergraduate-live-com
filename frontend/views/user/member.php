<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Member;
use frontend\assets\AppAsset;

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
        <p class="user-right-title">我的会员</p>
        <div class="coupon-wrapper member-wrapper">
            <ul class="coupon-title-line">
                <li class="coupon-money">会员名称</li>
                <li class="coupon-money">会员价格</li>
                <li class="coupon-daterange">有效期</li>
            </ul>
            <ul class="coupon-content-line _coupon-list">
                <?php foreach ($member_models as $member) { 
                ?>
                <li>
                    <p class="coupon-name"><?= $member->member_name ?></p>
                    <p class="coupon-money"><?= $member->discount ?></p>
                    <p class="coupon-daterange"><?= date('Y-m-d', $member->add_time) ?>至<?= date('Y-m-d', $member->end_time) ?></p>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>