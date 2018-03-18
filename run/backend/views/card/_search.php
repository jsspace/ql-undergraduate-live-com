<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'card_id') ?>

    <?= $form->field($model, 'card_pass') ?>

    <?= $form->field($model, 'money') ?>

    <?= $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'use_status') ?>

    <?php // echo $form->field($model, 'print_status') ?>

    <?php // echo $form->field($model, 'use_time') ?>

    <?php // echo $form->field($model, 'user_phone') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
