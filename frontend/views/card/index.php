<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/card.css');

$this->title = '金币充值';
?>
<div class="card-wrapper">
    <div class="card-form">
        <div class="card-input">
            <!-- <p class="large-title">
                <span class="color">充</span>金币
                <span class="color">送</span>金币
            </p>
            <p class="subtitle">充200送20&nbsp;&nbsp;充500送50</p> -->
            <p class="card-tips">
                <?php if (Yii::$app->user->isGuest) { ?>
                    金币充值仅会员可用，请先<a href="/site/login">&nbsp;&nbsp;登录&nbsp;&nbsp;</a>或<a href="/site/signup">&nbsp;&nbsp;注册&nbsp;&nbsp;</a>
                <?php } else { ?>
                    <span class="user-info">
                        <img src="<?= Yii::$app->user->identity->picture; ?>"/>
                        <em><?= Yii::$app->user->identity->username ?></em>
                        <strong>当前金币数量：<i><?= $gold_balance ?></i>个</strong>
                    </span>
                <?php } ?>
            </p>
            <?php if ( !(Yii::$app->user->isGuest)) { ?>
            <p class="" style="margin-bottom: 15px;"><span style="color:red ">1</span>元人民币可兑换<span style="color:red ">10</span>个金币</p>
            <div>
                <?php $form = ActiveForm::begin(['id' => 'coin-buy-form', 'action' => Url::to(['card/buy'])]); ?>
                <p class="card-section">
                <span class="div-ele">
                    <input type="text" placeholder="请输入购买金币数量(10整数倍)" name="gold_num" id="goldNum">
                    <span class="empty-tip num-empty">请输入购买金币数量(10的整数倍),当前输入有误</span>
                </span>
                <?= Html::submitButton('提交订单', ['class' => 'submit-btn checkRule']) ?>
                </p>
                <?php ActiveForm::end(); ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="deposit-step">
        <dl class="wp">
            <dt>购买流程<i></i></dt>
            <dd><i>1</i>
                注册成为网站会员<br>(已注册用户请直接登录)
            </dd>
            <dd><i>2</i>
                输入框输入需购买的金币数量<br>
                并提交购买
            </dd>
            <dd class="last"><i>3</i><span>充值成功</span></dd>
        </dl>
    </div>
</div>

<script type="text/javascript" src="/skin/layer.js"></script>
<script>
    $(function () {
        $('.checkRule').on('click', function (e) {
            if ($(this).hasClass('disabled-submit')) {
                e.preventDefault();
            } else {
                var numCheck = 0;
                var goldNum = $('#goldNum').val();
                if (!goldNum) {
                     numCheck = numCheck + 1;
                }
                // 校验规则
                var rules = /^\+?[1-9][0-9]*$/;　　//正整数
                if(!rules.test(goldNum)){
                    numCheck = numCheck + 1;
                }
                var isTen=goldNum%10;
                if(isTen!==0){
                    numCheck = numCheck + 1;
                }
                if(numCheck !==0){
                    $('.num-empty').show();
                    $('#goldNum').focus();
                    return false;
                }else{
                    $('.num-empty').hide();
                    return true;
                }
            }
        });
    });
</script>
