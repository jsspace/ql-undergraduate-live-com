<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
use backend\models\Course;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CollectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Collections');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'userid',
                'value'=> function ($model) {
                    return User::item($model->userid);
                },
                'filter' => User::users('student'),
            ],
            [
                'attribute' => 'courseid',
                'value'=> function ($model) {
                    return Course::item($model->courseid);
                },
                'filter' => Course::allItems(),
            ],
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
