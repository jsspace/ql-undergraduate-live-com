<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/loginRegister.css');

$this->title = 'Signup';
?>
<div class="site-login-register site-signup">
    <div class="login-kuang">
        <div class="login-bg">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>
                
                <?= $form->field($model, 'phone') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= Html::activeHiddenInput($model,'invite',array('value'=>$uid)) ?>

                <div class="form-group login-section">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
