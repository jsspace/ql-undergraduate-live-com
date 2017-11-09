<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/loginRegister.css');

$this->title = 'Login';
?>
<div class="site-login-register site-login">
    <div class="login-kuang">
        <div class="login-bg">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="forget-section">
                    <?= Html::a('忘记密码', ['site/change-password']) ?>.
                </div>

                <div class="form-group login-section">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <a href="/site/signup">注册</a>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
