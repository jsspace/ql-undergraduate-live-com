<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
use backend\models\Course;
use backend\models\Lookup;
use backend\models\CourseSection;
use backend\models\UserStudyLog;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserStudyLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '用户学习时长统计');
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
            [
                'attribute' => '网课学习时长（分钟）',
                'value'=> function ($model) {
                    $duration = UserStudyLog::find()
                    ->where(['userid'=>$model->userid])
                    ->andWhere(['type'=>1])
                    ->sum('duration');
                    return $duration;
                },
            ],
            [
                'attribute' => '直播课学习时长（分钟）',
                'value'=> function ($model) {
                    $duration = UserStudyLog::find()
                    ->where(['userid'=>$model->userid])
                    ->andWhere(['type'=>0])
                    ->sum('duration');
                    return $duration;
                },
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
