<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Audio */

$this->title = '更新音频';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="audio-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
