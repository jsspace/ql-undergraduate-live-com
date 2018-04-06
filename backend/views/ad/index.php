<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Ad'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'title',
            //'url:url',
            'img',
            [
                'attribute' => 'online',
                'value' => function ($model) {
                    return $model->online==1? '上线': '下线';
                },
                'filter'=>['1' => '上线',0 => '下线'],
             ],
             [
                'attribute' => 'ismobile',
                'value' => function ($model) {
                    return $model->online==1? 'mobile': 'pc';
                },
                'filter'=>['1' => 'mobile',0 => 'pc'],
             ],
             'position'
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
