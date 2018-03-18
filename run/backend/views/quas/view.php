<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\CourseComent;
use backend\models\Course;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\Quas */

$this->title = '查看问题';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Quas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quas-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'student_id',
                'value' => User::item($model->student_id),
            ],
            'question:ntext',
            'answer:ntext',
            [
                'attribute' => 'course_id',
                'value' => Course::item($model->course_id),
            ],
            [
                'attribute' => 'check',
                'value'=> CourseComent::item($model->check),
            ],
            'question_time:datetime',
            'answer_time:datetime',
        ],
    ]) ?>

</div>
