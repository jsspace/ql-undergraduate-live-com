<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Course;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseNews */

$this->title = '查看软文';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-news-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'attribute' => 'list_pic',
                'label' => '列表图片',
                'format' => ['image',['width'=>'40']]
            ],
            'des:html',
            [
                'attribute' => 'courseid',
                'value' => Course::items($model->courseid),
            ],
            [
                'attribute' => 'onuse',
                'value'=> $model->onuse == 1 ? '上线' : '下线',
            ],
            'position',
            'view',
            'create_time:datetime',
        ],
    ]) ?>

</div>
