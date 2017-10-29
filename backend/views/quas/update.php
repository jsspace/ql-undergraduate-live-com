<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Quas */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Quas',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Quas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="quas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
