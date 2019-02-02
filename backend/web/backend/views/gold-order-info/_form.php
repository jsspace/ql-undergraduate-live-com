<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoldOrderInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gold-order-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gold_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_status')->textInput() ?>

    <?= $form->field($model, 'pay_status')->textInput() ?>

    <?= $form->field($model, 'pay_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_paid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'add_time')->textInput() ?>

    <?= $form->field($model, 'confirm_time')->textInput() ?>

    <?= $form->field($model, 'pay_time')->textInput() ?>

    <?= $form->field($model, 'invalid_time')->textInput() ?>

    <?= $form->field($model, 'gift_coins')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
