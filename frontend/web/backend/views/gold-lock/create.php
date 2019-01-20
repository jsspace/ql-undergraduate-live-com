<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\GoldLock */

$this->title = 'Create Gold Lock';
$this->params['breadcrumbs'][] = ['label' => 'Gold Locks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gold-lock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
