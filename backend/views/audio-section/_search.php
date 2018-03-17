<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AudioSectionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="audio-section-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'audio_name') ?>

    <?= $form->field($model, 'audio_author') ?>

    <?= $form->field($model, 'audio_url') ?>

    <?= $form->field($model, 'audio_id') ?>

    <?php // echo $form->field($model, 'click_time') ?>

    <?php // echo $form->field($model, 'collection') ?>

    <?php // echo $form->field($model, 'share') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
