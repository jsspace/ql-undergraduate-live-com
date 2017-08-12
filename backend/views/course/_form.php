<?php

use backend\assets\AppAsset;
use backend\models\User;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */
/* @var $form yii\widgets\ActiveForm */

AppAsset::addCss($this, '@web/css/course.css');
?>

<div class="section course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>
    
    <div class="course_category_wrap">
        <?= $form->field($model, 'category_name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        <div class="category-result"></div>
    </div>

    <!-- <?//= $form->field($model, 'teacher_id')->dropDownList(User::items('教师'), ['prompt'=>'1']) ?>

    <?//= $form->field($model, 'head_teacher')->dropDownList(User::items('班主任'), ['prompt'=>'1']) ?> -->

    <?= $form->field($model, 'teacher_id')->dropDownList(['prompt'=>1]) ?>

    <?= $form->field($model, 'head_teacher')->dropDownList(['prompt'=>1]) ?>

    <?= $form->field($model, 'list_pic')->widget(FileInput::classname(),
        [
            'options' => ['accept' => 'image/png,image/jpeg'],
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
                'initialPreview' => [
                    $model->list_pic ? Html::img($model->list_pic, $options = ['width' => '170px']) : null,
                ]
            ],
        ]) ?>

    <?= $form->field($model, 'home_pic')->widget(FileInput::classname(),
        [
                'options' => ['accept' => 'image/png,image/jpeg'],
                'pluginOptions' => [
                    'showPreview' => true,
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false,
                    'initialPreview' => [
                        $model->home_pic ? Html::img($model->home_pic, $options = ['width' => '170px']) : null,
                    ],
                ]
        ]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'des')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => [
            'filebrowserUploadUrl' => Url::to(['course/uploadimg'], true)
        ],
    ]) ?>

    <!-- <?//= $form->field($model, 'view')->textInput() ?>

    <?//= $form->field($model, 'collection')->textInput() ?>

    <?//= $form->field($model, 'share')->textInput() ?>

    <?//= $form->field($model, 'online')->textInput() ?> -->

    <?= $form->field($model, 'onuse')->dropDownList(['1'=>'可用', '0'=>'不可用']) ?>

    <!-- <?//= $form->field($model, 'create_time')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '保存') : Yii::t('app', '保存'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src='/js/course.js'></script>