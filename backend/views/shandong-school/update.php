<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ShandongSchool */

$this->title = Yii::t('app', '更新');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shandong Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="shandong-school-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
