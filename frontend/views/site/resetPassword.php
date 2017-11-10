<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>

                <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'change_password_code')->textInput(['autofocus' => true]) ?>
                <div class="signup-line verify-code has-error">
                    <a href="javascript:void(0)" class="btn verify-btn getlogincode">获取验证码</a>
                    <p class="help-block help-block-error"></p>
                </div>
                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
$('.getlogincode').on('click', function() {
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
