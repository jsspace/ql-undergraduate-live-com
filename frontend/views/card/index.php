<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
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
                    <span class="user-info">
                        <img src="<?= Url::to('@web/'.Yii::$app->user->identity->picture); ?>"/>
                        <em><?= Yii::$app->user->identity->username ?></em>
                        <strong>当前余额：<i>0.00</i>金币</strong>
                    </span>
                <?php } ?>
            </p>
            <p class="card-section">
                <span class="div-ele">
                    <input type="text" placeholder="请输入学习卡号" id="cardNum">
                    <span class="empty-tip num-empty">请输入学习卡号</span>
                </span>
                <span class="div-ele">
                    <input type="text" placeholder="请输入学习卡密码" id="cardPwd">
                    <span class="empty-tip pwd-empty">请输入学习卡密码</span>
                </span>
                <a href="javascript:void(0)" class="submit-btn <?php if (Yii::$app->user->isGuest) { ?> disabled-submit <?php } ?>">提交充值</a>
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

<script>
    $(function () {
        $('.submit-btn').on('click', function (e) {
            if ($(this).hasClass('disabled-submit')) {
                e.preventDefault();
            } else {
                var cardNum = $('#cardNum').val();
                var cardPwd = $('#cardPwd').val();
                if (!cardNum) {
                    $('.num-empty').show();
                    $('#cardNum').focus();
                    return false;
                }
                if (!cardPwd) {
                    $('.pwd-empty').show();
                    $('#cardPwd').focus();
                    return false;
                }
                $.ajax({
                    type: '',
                    url: '',
                    data: {
                        'cardNum': cardNum,
                        'cardPwd': cardPwd
                    },
                    success: function () {
                        layer.alert('金币充值成功', {icon: 1});
                    },
                    error: function () {
                        console.log('error')
                    }
                });
            }
        });
    });
</script>
