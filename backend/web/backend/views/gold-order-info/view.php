<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\GoldOrderInfo */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Gold Order Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gold-order-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'order_sn',
            'user_id',
            'gold_num',
            'order_status',
            'pay_status',
            'pay_id',
            'pay_name',
            'pay_fee',
            'money_paid',
            'order_amount',
            'add_time:datetime',
            'confirm_time:datetime',
            'pay_time:datetime',
            'invalid_time:datetime',
            'gift_coins',
        ],
    ]) ?>

</div>
