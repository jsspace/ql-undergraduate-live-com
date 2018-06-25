<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MemberGoods */

$this->title = $model->rec_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Member Goods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->rec_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->rec_id], [
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
            'rec_id',
            'user_id',
            'order_sn',
            'member_id',
            'course_category_id',
            'member_name',
            'price',
            'discount',
            'add_time:datetime',
            'end_time:datetime',
            'pay_status',
        ],
    ]) ?>

</div>
