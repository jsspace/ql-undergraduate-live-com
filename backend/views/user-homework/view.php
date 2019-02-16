<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Course;
use backend\models\CourseSection;
use backend\models\User;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\UserHomework */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Homeworks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-homework-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'course_id',
                'value' => Course::item($model->course_id),
            ],
            [
                'attribute' => 'section_id',
                'value' => CourseSection::item($model->section_id)
            ],

            [
                'attribute' => 'pic_url',
                'format' => 'raw',
                'value' => function($model) {
                    $images = '';
                    $pics = explode(';', $model->pic_url);
                    $pics = array_filter($pics);
                    foreach ($pics as $pic) {
                        $images = $images.Html::img($pic, ['height' => 40]);
                    }
                    return $images;
                },
            ],
            [
                'attribute' => 'status',
                'value' => Lookup::item('homework_status', $model->status)
            ],
            'submit_time',
            [
                'attribute' => 'user_id',
                'value' => User::item($model->user_id)
            ],
        ],
    ]) ?>

</div>
