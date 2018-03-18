<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AudioSection */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Audio Section',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audio Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="audio-section-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>