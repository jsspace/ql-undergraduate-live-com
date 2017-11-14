<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderInfo */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
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
            'order_status',
            'pay_status',
            'consignee',
            'mobile',
            'email:email',
            'pay_id',
            'pay_name',
            'goods_amount',
            'pay_fee',
            'money_paid',
            'integral',
            'integral_money',
            'bonus',
            'order_amount',
            'add_time',
            'confirm_time',
            'pay_time',
            'bonus_id',
            'is_separate',
            'parent_id',
            'discount',
            'invalid_time',
            'course_ids',
            'coupon_ids',
            'coupon_money',
        ],
    ]) ?>

</div>
