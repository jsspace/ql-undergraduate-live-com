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
                'label' => iconv('GBK', 'UTF-8', '�γ�'),
                'value' => function ($model) {
                    return Course::item($model->course_id);
                },
                'filter' => Course::allItems(),
            ],
            [
                'attribute' => 'section_id',
                'label'=> iconv('GBK', 'UTF-8', '�ڴ�'),
                'value' => function ($model) {
                    return CourseSection::item($model->section_id);
                },
                'filter' => CourseSection::allItems(),
            ],
            [
                'attribute' => 'pic_url',
                'label' => iconv('GBK', 'UTF-8', 'ͼƬ'),
                'value' => function ($model) {
                   $images = '';
                   $pics = explode(';', $model->pic_url);
                   for ($i = 0; $i < count($pics); $i++) {
                       $images = $images.Html::img($pics[$i], ['width' => 100, 'height' => 80, 'alt' => $pics[$i]]);
                   }
                   return $images;
                },
//                'format' => ['image',['height'=>'100']],
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'label' => iconv('GBK', 'UTF-8', '״̬'),
                'value' => function ($model) {
                    return Lookup::item('homework_status', $model->status);
                },
                'filter' => [1 => iconv('GBK', 'UTF-8', '���ύ'),
                             2 => iconv('GBK', 'UTF-8', '���ͨ��'),
                             3 => iconv('GBK', 'UTF-8', '���δͨ��')],
            ],
            'submit_time',
            [
                'attribute' => 'user_id',
                'label' => iconv('GBK', 'UTF-8', 'ѧ��'),
                'value' => function ($model) {
                    return User::item($model->user_id);
                },
                'filter' => User::users('student'),
            ],

            [
                 'class' => 'yii\grid\ActionColumn',
                 'header' => iconv('GBK', 'UTF-8', '����')
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
