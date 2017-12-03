<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Coupon;
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
        <p class="user-right-title">我的钱包</p>
        <p class="coin-con">
            <span class="coin-left">
                钱包余额：<?= $coins[0]->balance ?>元&nbsp;&nbsp;&nbsp;&nbsp;<a href="/card">充值钱包</a>
            </span>
            <span class="coin-right">不知道如何充值或使用钱包？<a href="">请戳这里</a></span>
        </p>
        <div class="coupon-wrapper coin-wrapper">
            <ul class="coupon-title-line">
                <li class="coin-id">ID</li>
                <li>收支</li>
                <li>钱包余额</li>
                <li class="coin-detail">操作明细</li>
                <li>操作时间</li>
            </ul>
            <ul class="coupon-content-line">
                <?php foreach ($coins as $key => $coin) { ?>
                 <li>
                    <p class="coin-id"><?= $coin->card_id ?></p>
                    <p><?= $coin->income ?></p>
                    <p><?= $coin->balance ?></p>
                    <p class="coin-detail"><?= $coin->operation_detail ?></p>
                    <p><?= date('Y-m-d H:i:s', $coin->operation_time) ?></p>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>