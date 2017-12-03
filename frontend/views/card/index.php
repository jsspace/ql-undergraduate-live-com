<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/card.css');

$this->title = '金币充值';
?>
<div class="card-wrapper">
    <div class="card-form">
        <div class="card-input">
            <p class="large-title">
                <span class="color">充</span>金币
                <span class="color">送</span>金币
            </p>
            <p class="subtitle">充200送20&nbsp;&nbsp;充500送50</p>
            <p class="card-tips">
                <?php if (Yii::$app->user->isGuest) { ?>
                    金币充值仅会员可用，请先<a href="/site/login">&nbsp;&nbsp;登录&nbsp;&nbsp;</a>或<a href="/site/signup">&nbsp;&nbsp;注册&nbsp;&nbsp;</a>
                <?php } else { ?>
                    
                <?php } ?>
            </p>
            <p class="card-section">
                <input type="text" placeholder="请输入学习卡号">
                <input type="text" placeholder="请输入学习卡密码">
                <a href="javascript:void(0)" class="submit-btn">提交充值</a>
                <a href="" class="card-link">如何使用金币购买课程？</a>
            </p>
        </div>
    </div>
    <div class="deposit-step">
        <dl class="wp">
            <dt>充值流程<i></i></dt>
            <dd><i>1</i>
                注册成为网站会员<br>(已注册用户请直接登录)
            </dd>
            <dd><i>2</i>
                输入框输入学习卡号及密码<br>
                并提交充值
            </dd>
            <dd class="last"><i>3</i><span>充值成功</span></dd>
        </dl>
    </div>
</div>
