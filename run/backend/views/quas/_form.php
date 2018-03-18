<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\CourseComent;

/* @var $this yii\web\View */
/* @var $model backend\models\Quas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'answer')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'check')->dropDownList(CourseComent::items()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
