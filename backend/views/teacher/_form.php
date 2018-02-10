<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
$is_admin = array_key_exists('admin',$roles_array);

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList(['1'=>'女', '0'=>'男']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'office')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goodat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'picture')->widget(FileInput::classname(),
        [
            'options' => ['accept' => 'image/png,image/jpeg'],
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
                'initialPreview' => [
                    $model->picture ? Html::img('/'.$model->picture, $options = ['width' => '170px']) : null,
                ]
            ],
        ]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?php // $form->field($model, 'invite')->textInput() ?>
    <?php if(empty($model->bank) || $is_admin) {?>
    <?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>
	<?php }?>
	<?php if(empty($model->bank_username) || $is_admin) {?>
    <?= $form->field($model, 'bank_username')->textInput(['maxlength' => true]) ?>
	<?php }?>
	<?php if(empty($model->bankc_card) || $is_admin) {?>
    <?= $form->field($model, 'bankc_card')->textInput() ?>
	<?php }?>
    <?php // $form->field($model, 'created_at')->textInput() ?>

    <?php // $form->field($model, 'updated_at')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
