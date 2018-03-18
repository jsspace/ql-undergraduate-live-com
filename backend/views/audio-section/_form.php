<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\AppAsset;
use backend\models\Audio;
/* @var $this yii\web\View */
/* @var $model backend\models\AudioSection */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="audio-section-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'audio_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audio_author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audio_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audio_id')->dropDownList(Audio::items(), ['prompt'=>'- 请选择分类 -']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
