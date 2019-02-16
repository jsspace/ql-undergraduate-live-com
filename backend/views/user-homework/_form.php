<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Lookup;
use backend\models\Course;
use backend\models\CourseSection;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\UserHomework */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-homework-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course_id')->textInput(['value'=>Course::item($model->course_id), 'disabled'=>'disabled']) ?>

    <?= $form->field($model, 'section_id')->textInput(['value'=>CourseSection::item($model->section_id), 'disabled'=>'disabled']) ?>

    <?=\yii\widgets\DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'pic_url',
                'format' => 'raw',
                'value' => function($model) {
                    $images = '';
                    $pics = explode(';', $model->pic_url);
                    for ($i = 0; $i < count($pics); $i++) {
                        $images = $images.Html::img($pics[$i], ['width' => 300, 'height' => 220, 'alt' => $pics[$i]]);
                    }
                    return $images;
                },
            ],
        ]
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList(
            Lookup::items('homework_status')) ?>

    <?= $form->field($model, 'submit_time')->textInput(['disabled'=>'disabled']) ?>

    <?= $form->field($model, 'user_id')->textInput(['value'=>User::item($model->user_id), 'disabled'=>'disabled']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
