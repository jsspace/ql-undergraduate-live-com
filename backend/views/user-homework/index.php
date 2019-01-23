<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Course;
use backend\models\CourseSection;
use backend\models\User;
use backend\models\Lookup;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserHomeworkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Homeworks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-homework-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'course_id',
                'label' => iconv('GBK', 'UTF-8', '课程'),
                'value' => function ($model) {
                    return Course::item($model->course_id);
                }
            ],
            [
                'attribute' => 'section_id',
                'label'=> iconv('GBK', 'UTF-8', '节次'),
                'value' => function ($model) {
                    return CourseSection::item($model->section_id);
                }
            ],
            [
                'attribute' => 'pic_url',
                'label' => iconv('GBK', 'UTF-8', '图片'),
                'format' => ['image',['height'=>'100']],
            ],
            [
                'attribute' => 'status',
                'label' => iconv('GBK', 'UTF-8', '状态'),
                'value' => function ($model) {
                    return Lookup::item('homework_status', $model->status);
                }
            ],
            'submit_time',
            [
                'attribute' => 'user_id',
                'label' => iconv('GBK', 'UTF-8', '学生'),
                'value' => function ($model) {
                    return User::item($model->user_id);
                }
            ],

            [
                 'class' => 'yii\grid\ActionColumn',
                 'header' => iconv('GBK', 'UTF-8', '操作')
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
