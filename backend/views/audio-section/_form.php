<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AudioSection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="audio-section-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'audio_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audio_author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audio_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audio_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'click_time')->textInput() ?>

    <?= $form->field($model, 'collection')->textInput() ?>

    <?= $form->field($model, 'share')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
