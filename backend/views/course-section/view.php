<?php

use backend\models\CourseChapter;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSection */

AppAsset::addCss($this,'@web/css/chapter_section.css');
?>
<div class="course-section-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'chapter_id',
                'value' => CourseChapter::item($model->chapter_id),
            ],
            'name',
            'video_url:url',
            'playback_url:url',
            [
                'attribute' => 'paid_free',
                'value'=> $model->paid_free == 1 ? '付费' : '免费',
            ],
            [
                'attribute' => 'type',
                'value'=> $model->type == 1 ? '网课' : '直播课',
            ],
            'duration',
            'start_time:datetime',
            'position',
        ],
    ]) ?>

</div>
