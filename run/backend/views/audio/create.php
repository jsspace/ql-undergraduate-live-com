<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Audio */

$this->title = Yii::t('app', 'Create Audio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audio-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
