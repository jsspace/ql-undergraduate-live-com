<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = '查看课程';
?>
<div class="course-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'course_name',
            'category_name',
            'list_pic',
            'home_pic',
            'teacher_id',
            'head_teacher',
            'price',
            'discount',
            'des:ntext',
            'view',
            'collection',
            'share',
            'online',
            'onuse',
            'create_time:datetime',
        ],
    ]) ?>

</div>
