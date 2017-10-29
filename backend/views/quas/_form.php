<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Quas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'teacher_id')->textInput() ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'answer')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'question_time')->textInput() ?>

    <?= $form->field($model, 'answer_time')->textInput() ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'check')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
