<?php

use backend\assets\AppAsset;
use backend\models\Course;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CoursePackage */
/* @var $form yii\widgets\ActiveForm */
AppAsset::addCss($this, '@web/css/course.css');
?>

<div class="course-package-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="package-category-wrap">
        <?= $form->field($model, 'category_name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        <div class="package-category-result"></div>
    </div>

    <div class="package-course-wrap">
        <div class="form-group field-coursepackage-course has-success">
            <label class="control-label" for="coursepackage-course">课程</label>
            <div class="course_wrap form-control">
                <div class="pcourse-course"></div>
                <input type="text" id="coursepackage-course" name="CoursePackage[course]" value="媒体" maxlength="255" autocomplete="off" aria-invalid="false">
            </div>
        </div>
        <div class="course-result"></div>
    </div>

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

    <!--<?//= $form->field($model, 'view')->textInput() ?>
    
    <?//= $form->field($model, 'collection')->textInput() ?>
    
    <?//= $form->field($model, 'share')->textInput() ?>
    
    <?//= $form->field($model, 'online')->textInput() ?>-->
    <?= $form->field($model, 'onuse')->dropDownList(['1'=>'可用', '0'=>'不可用']) ?>

    <!--<?//= $form->field($model, 'create_time')->textInput() ?>

    <?//= $form->field($model, 'head_teacher')->dropDownList(User::items('班主任'), ['prompt'=>'1']) ?>-->

    <?= $form->field($model, 'head_teacher')->dropDownList(['1'=>1]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src='/js/course.js'></script>