<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AudioCategory */

$this->title = '更新分类';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audio Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="audio-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
