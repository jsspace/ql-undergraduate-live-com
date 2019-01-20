<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\GoldLog */

$this->title = 'Create Gold Log';
$this->params['breadcrumbs'][] = ['label' => 'Gold Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gold-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
