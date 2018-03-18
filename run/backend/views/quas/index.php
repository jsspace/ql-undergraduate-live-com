<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Course;
use backend\models\User;
use backend\models\CourseComent;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\QuasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Quas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quas-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute' => 'student_id',
                'value'=> function ($model) {
                    return User::item($model->student_id);
                },
                'filter' => User::users('student'),
            ],
            [
                'attribute' => 'teacher_id',
                'value'=> function ($model) {
                    return User::item($model->teacher_id);
                },
                'filter' => User::users('teacher'),
            ],
            'question:ntext',
            'answer:ntext',
            // 'question_time:datetime',
            // 'answer_time:datetime',
            [
                'attribute' => 'course_id',
                'value'=> function ($model) {
                    return Course::item($model->course_id);
                },
                'filter' => Course::allItems(),
            ],
            [
                'attribute' => 'check',
                'value'=> function ($model) {
                    return CourseComent::item($model->check);
                },
                'filter' => CourseComent::items(),
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
