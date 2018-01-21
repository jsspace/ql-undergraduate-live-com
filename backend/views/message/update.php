<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Message */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Message',
]) . $model->msg_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->msg_id, 'url' => ['view', 'id' => $model->msg_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
