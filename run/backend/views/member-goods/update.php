<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MemberGoods */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Member Goods',
]) . $model->rec_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Member Goods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rec_id, 'url' => ['view', 'id' => $model->rec_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="member-goods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
