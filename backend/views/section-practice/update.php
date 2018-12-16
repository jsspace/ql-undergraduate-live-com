<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SectionPractice */

$this->title = Yii::t('app', 'Update Section Practice: {nameAttribute}', [
    'nameAttribute' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Section Practices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="section-practice-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<style type="text/css">
    .main-sidebar {
        display: none;
    }
    .content-wrapper,
    .main-footer {
        margin-left: 0;
    }
</style>