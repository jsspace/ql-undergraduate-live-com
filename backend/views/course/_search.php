<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?php echo $form->field($model, 'category_name') ?>

    <!-- <?//= $form->field($model, 'teacher_id')->dropDownList(User::items('教师'), ['prompt'=>'1']) ?>

    <?//= $form->field($model, 'head_teacher')->dropDownList(User::items('班主任'), ['prompt'=>'1']) ?> -->

    <?= $form->field($model, 'teacher_id') ?>

    <?php echo $form->field($model, 'head_teacher') ?>

    <?= $form->field($model, 'onuse')->dropDownList(['prompt'=>'', '1'=>'可用', '0'=>'不可用']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', '重置'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
