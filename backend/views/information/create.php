<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Information */

$this->title = Yii::t('app', 'Create Information');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="information-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
