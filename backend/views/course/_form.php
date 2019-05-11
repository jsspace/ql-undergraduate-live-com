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

    <div class="course-teacher-wrap">
        <div class="form-group field-course-teacher_id required">
            <label class="control-label" for="course-teacher_id">授课教师</label>
            <input type="text" name="Course[teacher_id]" class="hidden-teacher-id _hidden-teacher-id" value="<?= $model->teacher_id; ?>">
            <div class="teacher-wrap _teacher-wrap form-control">
                <div class="course-teacher _course-teacher">
                    <?php
                        if (!empty($model->teacher_id)) {
                            $teachers = explode(',',$model->teacher_id);
                            $data = '';
                            foreach ($teachers as $teacher) {
                                $data.='<span class="tag" data-value='.$teacher.'>'.User::item($teacher).'<span class="remove"></span></span>';
                            }
                            echo $data;
                        }
                    ?>
                </div>
                <input type="text" id="course-teacher_id">
            </div>
            <div class="help-block"></div>
        </div>
        <div class="teacher-result _teacher-result"></div>
    </div>

    <?= $form->field($model, 'head_teacher')->dropDownList($head_teachers) ?>

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

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '保存') : Yii::t('app', '保存'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><script src='/js/course.js'></script>