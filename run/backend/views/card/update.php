<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Card */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Card',
]) . $model->card_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->card_id, 'url' => ['view', 'id' => $model->card_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="card-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
