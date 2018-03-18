<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\AudioCategory;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AudioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Audios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audio-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Audio'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            //'id',
            'des',
            'pic',
            [
                'attribute' => 'category_id',
                'value'=> function ($model) {
                    return AudioCategory::item($model->category_id);
                },
                'filter'=>AudioCategory::items(),
            ],
            'create_time:datetime',
            'click_time',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
