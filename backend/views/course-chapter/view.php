<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Course;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseChapter */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Chapters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .main-header,
    .main-sidebar,
    .main-footer,
    .content-header {
        display: none;
    }
</style>
<div class="course-chapter-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'attribute' => 'course_id',
                'value' => Course::item($model->course_id),
            ],
            'name',
            'position',
        ],
    ]) ?>

</div>
