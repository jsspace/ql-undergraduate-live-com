<?php

use backend\models\Course;
use backend\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseComentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Course Coments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-coment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Course Coment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute' => 'course_id',
                'value'=> function ($model) {
                    return Course::item($model->course_id);
                },
                'filter' => Course::allItems(),
            ],
            [
                'attribute' => 'user_id',
                'value'=> function ($model) {
                    return User::item($model->user_id);
                },
                'filter' => User::users('student'),
            ],
            'star',
            'content',
            [
                'attribute' => 'check',
                'value'=> function ($model) {
                    return $model->check == 1 ? '审核通过':'未审核';
                },
                'filter' => [1=>'审核通过',0=>'未审核' ],
            ],
            'create_time:datetime',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
