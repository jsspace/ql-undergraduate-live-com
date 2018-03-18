<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Course;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Data'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'name',
            [
                'attribute' => 'url_type',
                'value'=> function ($model) {
                    return $model->url_type == 1 ? '内链接':'外链接';
                },
                'filter' => [1=>'内链接',0=>'外链接' ],
            ],
            [
                'attribute' => 'course_id',
                'value'=> function ($model) {
                    return Course::item($model->course_id);
                },
                'filter' => Course::allItems(),
            ],
            //'summary:ntext',
            'ctime:datetime',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
