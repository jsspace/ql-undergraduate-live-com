<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoldLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gold-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'user_type') ?>

    <?= $form->field($model, 'point') ?>

    <?= $form->field($model, 'gold_balance') ?>

    <?php // echo $form->field($model, 'operation_type') ?>

    <?php // echo $form->field($model, 'operation_detail') ?>

    <?php // echo $form->field($model, 'operation_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
