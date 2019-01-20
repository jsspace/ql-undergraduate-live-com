<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GoldLock */

$this->title = 'Update Gold Lock: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Gold Locks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gold-lock-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
