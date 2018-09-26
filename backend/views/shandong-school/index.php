<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Provinces;
use backend\models\Cities;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShandongSchoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Shandong Schools');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shandong-school-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Shandong School'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'provinceid',
                'value' => function ($data) {
                    return Provinces::item($data->provinceid);
                }
            ],
            [
                'attribute' => 'cityid',
                'value' => function ($data) {
                    return Cities::item($data->cityid);
                },
                'filter'=>Cities::items('370000'),
            ],
            'school_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
