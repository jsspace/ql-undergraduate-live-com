<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
use backend\models\Course;
use backend\models\Lookup;
use backend\models\CourseSection;
use backend\models\UserHomework;
use backend\models\Cart;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserStudyLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'statistic');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-study-log-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return User::item($model->user_id);
                },
                'filter' => User::users('student'),
            ],

            [
                'attribute' => 'course_id',
                'value' => function($model) {
                    return Course::item($model->course_id);
                },
                'filter' => Course::allItems(),
            ],

            [
                'attribute' => iconv('GBK', 'UTF-8', '实交次数'),
                'value' => function($model) {
                    $sum = UserHomework::find()
                        ->where(['user_id' => $model->user_id, 'course_id' => $model->course_id, 'status' => 2])
                        ->count();
                    return $sum;
                },
            ],
            [
                'attribute' =>  iconv('GBK', 'UTF-8', '应交次数'),
                'value' => function($model) {
                    $homeworks = 0;
                    $courseModel = Course::find()
                        ->where(['id' => $model->course_id])
                        ->with([
                            'courseChapters' => function($query) {
                                $query->with(['courseSections' => function($query) {
                                    $query->with('courseSectionPoints');
                                }]);
                            }
                        ])
                        ->one();
                    $chapters = $courseModel->courseChapters;
                    foreach ($chapters as $key => $chapter){
                        $sections = $chapter->courseSections;
                        $homeworks += count($sections);
                    }
                    return $homeworks;
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>