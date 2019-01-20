<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Coupon;
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
        <p class="user-right-title">我的金币</p>
        <p class="coin-con">
            <span class="coin-left">
                钱包余额：<?php
                if (!empty($goldLogs[0])) {
                    echo $goldLogs[0]->gold_balance;
                } else {
                    echo 0;
                }
                ?>元&nbsp;&nbsp;&nbsp;&nbsp;<a href="/card">充值金币</a>
            </span>
            <span class="coin-right">不知道如何充值或使用钱包？<a href="/card/howto">请戳这里</a></span>
        </p>
        <div class="coupon-wrapper coin-wrapper">
            <ul class="coupon-title-line">
                <li class="coin-id">流水编号</li>
                <li>收支</li>
                <li>金币余额</li>
                <li class="coin-detail">操作明细</li>
                <li>操作时间</li>
            </ul>
            <ul class="coupon-content-line">
                <?php foreach ($goldLogs as $key => $goldLog) { ?>
                    <li>
                        <p><?= $goldLog->id ?></p>
                        <p><?= $goldLog->point ?></p>
                        <p><?= $goldLog->gold_balance ?></p>
                        <p class="coin-detail"><?= $goldLog->operation_detail ?></p>
                        <p><?= date('Y-m-d H:i:s', $goldLog->operation_time) ?></p>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>