<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Url;
use backend\models\Course;
use backend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseNews */
/* @var $form yii\widgets\ActiveForm */
AppAsset::addCss($this, '@web/css/course.css');
?>

<div class="course-news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'des')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => [
            'filebrowserUploadUrl' => Url::to(['course/uploadimg'], true)
        ],
    ]) ?>

    <div class="course-news-wrap">
        <div class="form-group field-coursenews-courseid required">
            <label class="control-label" for="coursenews-courseid">相关课程</label>
            <input type="text" name="CourseNews[courseid]" class="hidden-course-id _hidden-course-id" value="<?= $model->courseid; ?>">
            <div class="course-wrap _ncourse-wrap form-control">
                <div class="course-course _course-course">
                    <?php
                        $courses = explode(',',$model->courseid);
                        $data = '';
                        if ($courses[0] != '') {
                            foreach ($courses as $course) {
                                $data.='<span class="tag" data-value='.$course.'>'.Course::item($course).'<span class="remove"></span></span>';
                            }
                            echo $data;
                        }
                    ?>
                </div>
                <input type="text" id="coursenews-courseid" value="" maxlength="255" autocomplete="off" aria-invalid="false">
            </div>
        </div>
        <div class="newscourse-result _newscourse-result"></div>
    </div>

    <?= $form->field($model, 'onuse')->dropDownList(['1'=>'上线', '0'=>'下线']) ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src='/js/course.js'></script>
