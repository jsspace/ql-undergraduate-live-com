<?php

use backend\models\Course;
use backend\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseComent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-coment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course_id')->dropDownList(Course::allItems(), ['prompt'=>'- 请选择评价课程 -']) ?>

    <?= $form->field($model, 'user_id')->dropDownList(User::users('student'), ['prompt'=>'- 请选择评价学员 -']) ?>

    <?= $form->field($model, 'content')->textArea(['rows' => '3']) ?>

    <?= $form->field($model, 'check')->dropDownList(['1'=>'审核通过', '0'=>'未审核']) ?>

    <?= $form->field($model, 'star')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
