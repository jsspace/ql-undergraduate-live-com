<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GoldOrderInfoSeach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gold Order Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gold-order-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gold Order Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            'order_sn',
            'user_id',
            'gold_num',
            'order_status',
            //'pay_status',
            //'pay_id',
            //'pay_name',
            //'pay_fee',
            //'money_paid',
            //'order_amount',
            //'add_time:datetime',
            //'confirm_time:datetime',
            //'pay_time:datetime',
            //'invalid_time:datetime',
            //'gift_coins',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
