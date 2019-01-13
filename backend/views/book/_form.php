<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\CourseCategory;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->dropDownList($categorys) ?>

    <?= $form->field($model, 'pictrue')->widget(FileInput::classname(),
        [
            'options' => ['accept' => 'image/png,image/jpeg'],
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
                'initialPreview' => [
                    $model->pictrue ? Html::img($model->pictrue, $options = ['width' => '170px']) : null,
                ]
            ],
        ]) ?>
    
    <!-- <?= $form->field($model, 'publisher')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'des')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => [
            'filebrowserUploadUrl' => Url::to(['course/uploadimg'], true)
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
