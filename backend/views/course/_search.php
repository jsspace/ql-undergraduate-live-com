<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;
use backend\models\CourseCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section course-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'course_name') ?>

    <?= $form->field($model, 'category_name')->dropDownList(CourseCategory::items(), ['prompt' => '请选择']); ?>

    <?= $form->field($model, 'teacher_id')->dropDownList(User::users('teacher'), ['prompt' => '请选择']); ?>


    <?= $form->field($model, 'head_teacher')->dropDownList(User::users('head_teacher'), ['prompt' => '请选择']); ?>

   <!--  <?= $form->field($model, 'onuse')->dropDownList([1=>'可用', 0=>'不可用'],['prompt' => '请选择']) ?> -->

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', '重置'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
