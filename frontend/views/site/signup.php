<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\widgets\Pjax;

AppAsset::addCss($this,'@web/css/loginRegister.css');

$this->title = 'Signup';

?>
<div class="site-login-register site-signup">
    <div class="login-kuang">
        <div class="login-bg">
        <?php Pjax::begin(['id' => 'signup_pjax']) ?>
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'method'=>'post', 'options'=>['data-pjax'=>'#signup_pjax']]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => "form-control signup-input", 'placeholder' => "用户名"]) ?>

                <?= $form->field($model, 'email')->textInput(['class' => "form-control signup-input", 'placeholder' => "邮箱"]) ?>
                
                <?= $form->field($model, 'phone')->textInput(['class' => "form-control signup-input", 'placeholder' => "手机号"]) ?>
				<p class="signup-line verify-code">
                    <input type="text" name="verify_code" class="form-control verify-input" placeholder="验证码" />
                    <a href="javascript:void(0)" class="btn verify-btn">获取验证码</a>
                </p>
                <?= $form->field($model, 'password')->passwordInput(['class' => "form-control signup-input", 'placeholder' => "密码"]) ?>

                <?= Html::activeHiddenInput($model,'invite',array('value'=>$invite)) ?>

                <div class="form-group login-section">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        <?php Pjax::end() ?>
        </div>
    </div>
</div>
