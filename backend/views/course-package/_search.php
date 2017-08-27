<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CoursePackageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-package-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'course') ?>

    <?= $form->field($model, 'list_pic') ?>

    <?= $form->field($model, 'home_pic') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'category_name') ?>

    <?php // echo $form->field($model, 'des') ?>

    <?php // echo $form->field($model, 'view') ?>

    <?php // echo $form->field($model, 'collection') ?>

    <?php // echo $form->field($model, 'share') ?>

    <?php // echo $form->field($model, 'online') ?>

    <?php // echo $form->field($model, 'onuse') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'head_teacher') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
