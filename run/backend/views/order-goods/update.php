<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderGoods */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Order Goods',
]) . $model->rec_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Goods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rec_id, 'url' => ['view', 'id' => $model->rec_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="order-goods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
