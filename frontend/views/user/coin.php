<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Coupon;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="htcontent">
    <h2 class="htwx cc"><a href="/">首页</a>&gt;<a href="#">我的金币</a></h2>
    <div class="user-wrapper">
        <div class="right-content">
            <p class="coin-con">
                <span class="coin-left">
                    钱包余额：<?php
                    if (!empty($coins[0])) {
                        echo $coins[0]->balance;
                    } else {
                        echo 0;
                    }
                    ?>元&nbsp;&nbsp;&nbsp;&nbsp;<a href="/card">充值钱包</a>
                </span>
                <span class="coin-right">不知道如何充值或使用钱包？<a href="/card/howto">请戳这里</a></span>
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
</div>