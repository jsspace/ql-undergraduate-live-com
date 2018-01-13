<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\AppAsset;
use kartik\datetime\DateTimePicker; 

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSection */
/* @var $form yii\widgets\ActiveForm */
AppAsset::addCss($this,'@web/css/chapter_section.css');
?>

<div class="course-section-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(['1'=>'网课', '0'=>'直播课', '2'=>'直播答疑']) ?>

    <?= $form->field($model, 'paid_free')->dropDownList(['1'=>'付费', '0'=>'免费']) ?>

    <?= $form->field($model, 'video_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'roomid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'playback_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_time')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]);
    ?>

    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
