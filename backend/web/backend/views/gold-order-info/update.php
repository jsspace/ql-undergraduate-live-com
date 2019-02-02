<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GoldOrderInfo */

$this->title = 'Update Gold Order Info: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Gold Order Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'id' => $model->order_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gold-order-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
