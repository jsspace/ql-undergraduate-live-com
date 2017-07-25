<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseChapter */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Course Chapter',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Chapters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="course-chapter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
