<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/loginRegister.css');

$this->title = 'Reset password';
?>
<div class="site-login-register site-resetpwd">
    <div class="login-kuang">
        <div class="login-bg">
            <?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>

                <?= $form->field($model, 'phone')->textInput(['autofocus' => true,'placeholder' => '手机号']) ?>
                <?= $form->field($model, 'change_password_code')->textInput(['autofocus' => true, 'placeholder' => '验证码']) ?>
                <div class="signup-line verify-code has-error">
                    <a href="javascript:void(0)" class="btn verify-btn getlogincode">获取验证码</a>
                    <p class="help-block help-block-error"></p>
                </div>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => '新密码']) ?>

                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
$('.getlogincode').on('click', function() {
    var seconds = 60;
    if (!$(this).hasClass('disabled')) {
        $('.getlogincode').text('重新获取' + seconds +'s后').addClass('disabled');
        var timeout = setInterval(function() {
            if (seconds <= 0) {
                $('.getlogincode').text('获取验证码').removeClass('disabled');
                clearInterval(timeout);
            } else {
                --seconds;
                $('.getlogincode').text('重新获取' + seconds +'s后').addClass('disabled');
            }
        }, 1000);
    }
	$.ajax({
        url: '/site/chang-password-code',
        type: 'post',
        dataType:"json",
        data: {
            '_csrf-frontend': $('meta[name=csrf-token]').attr('content'),
            phone: $('.phone').val(),
        },
        success: function (data) {
            if (data.code !== 0) {
                $('.verify-code .help-block-error').text(data.message);
            } else {
            	$('.verify-code .help-block-error').text('');
            }
        }
    });
});
</script>
