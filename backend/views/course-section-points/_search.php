<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSectionPointsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-section-points-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'explain_video_url') ?>

    <?php // echo $form->field($model, 'video_url') ?>

    <?php // echo $form->field($model, 'roomid') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'playback_url') ?>

    <?php // echo $form->field($model, 'paid_free') ?>

    <?php // echo $form->field($model, 'section_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
