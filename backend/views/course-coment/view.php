<?php

use backend\models\Course;
use backend\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseComent */

$this->title = '查看评论';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Coments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-coment-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'course_id',
                'value' => Course::item($model->course_id),
            ],
            [
                'attribute' => 'user_id',
                'value' => User::item($model->user_id),
            ],
            'content',
            [
                'attribute' => 'check',
                'value'=> $model->check == 1 ? '审核通过' : '未审核',
            ],
            'create_time:datetime',
            'star',
        ],
    ]) ?>

</div>
