<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Data */

$this->title = '更新'.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="data-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
