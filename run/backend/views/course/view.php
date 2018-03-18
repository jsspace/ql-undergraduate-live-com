<?php

use backend\models\User;
use backend\models\CourseCategory;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = '查看课程';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section course-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'course_name',
            [
                'attribute' => 'category_name',
                'value' => CourseCategory::getNames($model->category_name),
            ],
            //'list_pic',
            //'home_pic',
            [
                'attribute' => 'list_pic',
                'label' => '列表图片',
                'format' => ['image',['width'=>'40']]
            ],
            [
                'attribute' => 'home_pic',
                'label' => '封面图片',
                'format' => ['image',['width'=>'40']]
            ],
            [
                'attribute' => 'teacher_id',
                'value' => User::item($model->teacher_id),
            ],
            //'teacher_id',
            [
                'attribute' => 'head_teacher',
                'value' => User::item($model->head_teacher),
            ],
            //'head_teacher',
            'price',
            'discount',
            'des:html',
            'view',
            'collection',
            'share',
            'online',
            [
                'attribute' => 'onuse',
                'value'=> $model->onuse == 1 ? '可用' : '不可用',
            ],
            'create_time:datetime',
        ],
    ]) ?>

</div>
