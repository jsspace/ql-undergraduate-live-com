<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Member;
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
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <p class="user-right-title">我的会员</p>
        <?php print_r($member_models)?>

        <div class="coupon-wrapper">
            <ul class="coupon-title-line">
                <li class="coupon-name">会员ID</li>
                <li class="coupon-money">会员名称</li>
                <li class="coupon-money">会员详情</li>
                <li class="coupon-daterange">有效期</li>
            </ul>
            <ul class="coupon-content-line _coupon-list">
                <?php foreach ($member_models as $key => $member) { 
                ?>
                <li>
                    <p class="coupon-name"><?= $member['member_id'] ?></p>
                    <p class="coupon-money"><?= $member['name'] ?></p>
                    <p class="coupon-status"><?= $member['content'] ?></p>
                    <p class="coupon-daterange"><?= date('Y-m-d', strtotime($member['add_time'])) ?>至<?= date('Y-m-d', strtotime($member['end_time'])) ?></p>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>