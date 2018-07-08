<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
use backend\models\Course;
use backend\models\Lookup;
use backend\models\CourseSection;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserStudyLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Study Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-study-log-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'userid',
                'value'=> function ($model) {
                    return User::item($model->userid);
                },
                'filter' => User::students(),
            ],
            'start_time:datetime',
            [
                'attribute' => 'duration',
                'value'=> function ($model) {
                    $format_number = number_format($model->duration/60, 2, ':', '');
                    return $format_number;
                },
            ],
            'current_time',
            [
                'attribute' => 'courseid',
                'value'=> function ($model) {
                    return Course::item($model->courseid);
                },
                'filter' => Course::allItems(),
            ],
            [
                'attribute' => 'sectionid',
                'value'=> function ($model) {
                    return CourseSection::item($model->sectionid);
                }
            ],
            /*[
                'attribute' => 'type',
                'value' => function ($model) {
                    return Lookup::item('video_type', $model->type);
                },
                'filter' => Lookup::items('video_type'),
            ],*/
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
