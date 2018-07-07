<?php

use backend\models\Course;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Lookup;
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
                'value' => Lookup::item('need_pay', $model->paid_free),
            ],
            [
                'attribute' => 'type',
                'value' => Lookup::item('video_type', $model->type),
            ],
            'duration',
            'start_time',
            'position',
        ],
    ]) ?>

</div>