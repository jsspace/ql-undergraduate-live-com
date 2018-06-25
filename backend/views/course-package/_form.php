<?php

use backend\assets\AppAsset;
use backend\models\Course;
use backend\models\CourseCategory;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\CoursePackage */
/* @var $form yii\widgets\ActiveForm */
AppAsset::addCss($this, '@web/css/course.css');
?>

<div class="course-package-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <!-- <div class="package-category-wrap">
        <div class="form-group field-coursepackage-category_name required">
            <label class="control-label" for="coursepackage-category_name">所属学院</label>
            <input type="text" name="CoursePackage[category_name]" class="hidden-package-category-name _hidden-package-category-name" value="<?= $model->category_name; ?>">
            <div class="pcategory-wrap _pcategory-wrap form-control">
                <div class="package-category _package-category">
                    <?php
                        if (!empty($model->category_name)) {
                            $categorys = explode(',',$model->category_name);
                            $data = '';
                            foreach ($categorys as $category) {
                                $data.='<span class="tag" data-value='.$category.'>'.CourseCategory::item($category).'<span class="remove"></span></span>';
                            }
                            echo $data;
                        }
                    ?>
                </div>
                <input type="text" id="coursepackage-category_name" value="" maxlength="255" autocomplete="off" aria-invalid="false">
            </div>
        </div>
        <div class="pcategory-result _pcategory-result"></div>
    </div> -->
    <?= $form->field($model, 'category_name')->dropDownList(CourseCategory::items()) ?>
    <div class="package-course-wrap">
        <div class="form-group field-coursepackage-course has-success">
            <label class="control-label" for="coursepackage-course">课程</label>
            <input type="text" name="CoursePackage[course]" class="hidden-course-id _hidden-course-id" value="<?= $model->course; ?>">
            <div class="course-wrap _course-wrap form-control">
                <div class="pcourse-course _pcourse-course">
                    <?php
                        if (!empty($model->course)) {
                            $courses = explode(',',$model->course);
                            $data = '';
                            foreach ($courses as $course) {
                                $data.='<span class="tag" data-value='.$course.'>'.Course::item($course).'<span class="remove"></span></span>';
                            }
                            echo $data;
                        }
                    ?>
                </div>
                <input type="text" id="coursepackage-course" value="" maxlength="255" autocomplete="off" aria-invalid="false">
            </div>
        </div>
        <div class="course-result _course-result"></div>
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

    <?= $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'head_teacher')->dropDownList(User::users('head_teacher')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src='/js/course.js'></script>