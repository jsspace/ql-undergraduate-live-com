<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseNewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Course News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-news-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Course News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            //'id',
            'title',
            //'list_pic',
            //'des:ntext',
            //'courseid',
            [
                'attribute' => 'onuse',
                'value'=> function ($model) {
                    return $model->onuse == 1 ? '上线':'下线';
                },
                'filter' => [1=>'上线',0=>'下线' ],
            ],
            'position',
            'view',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
