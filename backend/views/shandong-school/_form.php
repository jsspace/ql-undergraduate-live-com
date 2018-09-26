<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Cities;

/* @var $this yii\web\View */
/* @var $model backend\models\ShandongSchool */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shandong-school-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'provinceid')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'cityid')->dropDownList(Cities::items('370000')) ?>

    <?= $form->field($model, 'school_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
