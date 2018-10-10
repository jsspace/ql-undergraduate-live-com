<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\widgets\Pjax;
use backend\models\Cities;
use backend\models\ShandongSchool;

AppAsset::addCss($this,'@web/css/loginRegister.css');

$this->title = 'Signup';

?>
<div class="site-login-register site-signup">
    <div class="login-kuang">
        <div class="login-bg">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'method'=>'post',]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => "form-control signup-input", 'placeholder' => "用户名"]) ?>

                <?= $form->field($model, 'password')->passwordInput(['class' => "form-control signup-input", 'placeholder' => "密码"]) ?>

                <?= $form->field($model, 'cityid')->dropDownList(Cities::items('370000'), [
                        'prompt' => '- 请选择地区 -',
                        'onchange'=>'getSchools(this.value)'
                ]) ?>

                <?= $form->field($model, 'schoolid')->dropDownList(ShandongSchool::schools($model->cityid), [
                    'prompt' => '- 请选择学校 -',
                ]) ?>

                <?= $form->field($model, 'phone')->textInput(['class' => "form-control signup-input phone", 'placeholder' => "手机号"]) ?>
				
				<?= $form->field($model, 'smscode')->textInput(['class' => "form-control signup-input smscode", 'placeholder' => "验证码"]) ?>
				<div class="signup-line verify-code has-error">
<!--                     <input type="text" name="SignupForm[smscode]" class="form-control verify-input" placeholder="验证码" /> -->
                    <a href="javascript:void(0)" class="btn verify-btn getlogincode">获取验证码</a>
                    <p class="help-block help-block-error"></p>
                </div>

                <?= Html::activeHiddenInput($model,'invite',array('value'=>$invite)) ?>

                <div class="form-group login-section">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
function getSchools(cityid) {
    var csrfToken = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: "/shandong-school/schools",
        method: "post",
        data: {_csrf:csrfToken, cityid:cityid},
        success: function (data) {
            $("#signupform-schoolid").html("<option value=>- 请选择学校 -</option>");
            $("#signupform-schoolid").append(data);
        }
    });
}
$('.getlogincode').on('click', function() {
    var seconds = 60;
    if (!$(this).hasClass('disabled')) {
        $.ajax({
            url: '/site/logincode',
            type: 'post',
            dataType:"json",
            async: false,
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
        if ($('.help-block-error').text() === '') {
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
    }
});
</script>