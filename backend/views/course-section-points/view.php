<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSectionPoints */
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
<div class="course-section-points-view">
   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'name',
            [
                'attribute' => 'type',
                'value' => Lookup::item('video_type', $model->type),
            ],
            // 'start_time',
            //'explain_video_url:url',
            'video_url:url',
            //'roomid',
            'duration',
            //'playback_url:url',
            [
                'attribute' => 'paid_free',
                'value' => Lookup::item('need_pay', $model->paid_free),
            ],
            //'section_id',
            'position',
        ],
    ]) ?>

</div>
