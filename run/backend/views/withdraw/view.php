<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\Withdraw */

$this->title = '提现详情';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Withdraws'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->withdraw_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->withdraw_id], [
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
            //'withdraw_id',
            'role',
            [
                'attribute' => 'user_id',
                'value'=> function ($model) {
                    return User::item($model->user_id);
                }
            ],
            'fee',
            'info:ntext',
            'withdraw_date',
            'bankc_card',
            'bank',
            'bank_username',
            'status',
            'create_time',
        ],
    ]) ?>

</div>
