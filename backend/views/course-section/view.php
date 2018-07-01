<?php

use backend\models\Course;
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
                'attribute' => 'course_id',
                'value' => Course::item($model->course_id),
            ],
            'name',
            'video_url:url',
            'roomid',
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
            'start_time',
            'position',
        ],
    ]) ?>

</div>