<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\assets\AppAsset;
use backend\models\CourseSection;
use backend\models\Course;

/* @var $this yii\web\View */
/* @var $model backend\models\SectionPractice */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Section Practices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AppAsset::addCss($this,'@web/css/chapter_section.css');
?>
<style type="text/css">
    .main-sidebar {
        display: none;
    }
    .content-wrapper,
    .main-footer {
        margin-left: 0;
    }
</style>
<div class="section-practice-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'section_id',
                'value' => CourseSection::item($model->section_id),
            ],
            [
                'attribute' => 'course_id',
                'value' => Course::item($model->course_id),
            ],
            'title',
            'problem_des:html',
            'answer:html',
            'create_time:datetime',
        ],
    ]) ?>

</div>
