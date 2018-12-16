<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\CourseChapter;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSection */

$this->title = $model->name;
?>
<style type="text/css">
    .main-header,
    .main-sidebar,
    .main-footer,
    .content-header {
        display: none;
    }
</style>
<div class="course-section-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'name',
            [
                'attribute' => 'chapter_id',
                'value' => CourseChapter::item($model->chapter_id),
            ],
            'position',
        ],
    ]) ?>

</div>
