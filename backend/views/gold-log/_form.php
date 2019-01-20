<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoldLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gold-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'user_type')->textInput() ?>

    <?= $form->field($model, 'point')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gold_balance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operation_type')->textInput() ?>

    <?= $form->field($model, 'operation_detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'operation_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
