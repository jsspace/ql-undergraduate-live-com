<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSection */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Course Section',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="course-section-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
