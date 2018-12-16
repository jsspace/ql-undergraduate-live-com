<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSectionPoints */

$this->title = Yii::t('app', 'Update Course Section Points: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Section Points'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="course-section-points-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
