<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\GoldOrderInfo */

$this->title = 'Create Gold Order Info';
$this->params['breadcrumbs'][] = ['label' => 'Gold Order Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gold-order-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
