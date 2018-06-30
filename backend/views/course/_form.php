<?php

use backend\assets\AppAsset;
use backend\models\User;
use backend\models\CourseCategory;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */
/* @var $form yii\widgets\ActiveForm */

AppAsset::addCss($this, '@web/css/course.css');
?>

<div class="section course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_name')->dropDownList($categorys) ?>

    <?= $form->field($model, 'type')->dropDownList(Lookup::items('course_type')) ?>

    <?= $form->field($model, 'open_course_url')->textInput() ?>
    
    <?= $form->field($model, 'examination_time')->textInput() ?>

    <!-- <div class="course-category-wrap">
        <div class="form-group field-course-category_name required">
            <label class="control-label" for="course-category_name">课程分类</label>
            <input type="text" name="Course[category_name]" class="hidden-course-category-name _hidden-course-category-name" value="<?= $model->category_name; ?>">
            <div class="ccategory-wrap _ccategory-wrap form-control">
                <div class="course-category _course-category">
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
                <input type="text" id="course-category_name" value="" maxlength="255" autocomplete="off" aria-invalid="false">
            </div>
        </div>
        <div class="ccategory-result _ccategory-result"></div>
    </div> -->

    <?= $form->field($model, 'teacher_id')->dropDownList($teachers) ?>

    <!-- <?= $form->field($model, 'head_teacher')->dropDownList($head_teachers) ?> -->

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

    <?= $form->field($model, 'intro')->textInput() ?>

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

    <!-- <?= $form->field($model, 'onuse')->dropDownList(['1'=>'可用', '0'=>'不可用']) ?> -->

    <!-- <?//= $form->field($model, 'create_time')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '保存') : Yii::t('app', '保存'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><script src='/js/course.js'></script>