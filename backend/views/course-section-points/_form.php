<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSectionPoints */
/* @var $form yii\widgets\ActiveForm */
?>

<style type="text/css">
    .main-header,
    .main-sidebar,
    .main-footer,
    .content-header {
        display: none;
    }
</style>

<div class="course-section-points-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(Lookup::items('video_type')) ?>

    <!-- <?= $form->field($model, 'start_time')->textInput() ?> -->

    <!-- <?= $form->field($model, 'explain_video_url')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'video_url')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'roomid')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'playback_url')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'paid_free')->dropDownList(Lookup::items('need_pay')) ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
