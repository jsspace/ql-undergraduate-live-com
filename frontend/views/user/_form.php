<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>


	<?= $form->field($model, 'picture')->fileInput(['accept' => "image/png,image/jpeg"]) ?>
	<p class="hint">（请上传470x250尺寸的图片）</p>
    
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?php // $form->field($model, 'created_at')->textInput() ?>

    <?php // $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'office')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goodat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'invite')->textInput() ?>

   	<?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'wechat_img')->fileInput(['accept' => "image/png,image/jpeg"]) ?>
	<p class="hint">（请上传470x250尺寸的图片）</p>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
