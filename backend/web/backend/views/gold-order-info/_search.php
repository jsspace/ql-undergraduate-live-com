<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoldOrderInfoSeach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gold-order-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_sn') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'gold_num') ?>

    <?= $form->field($model, 'order_status') ?>

    <?php // echo $form->field($model, 'pay_status') ?>

    <?php // echo $form->field($model, 'pay_id') ?>

    <?php // echo $form->field($model, 'pay_name') ?>

    <?php // echo $form->field($model, 'pay_fee') ?>

    <?php // echo $form->field($model, 'money_paid') ?>

    <?php // echo $form->field($model, 'order_amount') ?>

    <?php // echo $form->field($model, 'add_time') ?>

    <?php // echo $form->field($model, 'confirm_time') ?>

    <?php // echo $form->field($model, 'pay_time') ?>

    <?php // echo $form->field($model, 'invalid_time') ?>

    <?php // echo $form->field($model, 'gift_coins') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
