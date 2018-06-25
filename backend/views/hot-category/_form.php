<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\CourseCategory;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\HotCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hot-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoryid')->dropDownList(CourseCategory::hotitems()); ?>

    <?= $form->field($model, 'backgroundcolor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->widget(FileInput::classname(),
        [
            'options' => ['accept' => 'image/png,image/jpeg'],
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
                'initialPreview' => [
                    $model->icon ? Html::img($model->icon, $options = ['width' => '64px']) : null,
                ]
            ],
        ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
