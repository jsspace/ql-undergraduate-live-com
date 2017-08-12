<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseCategory */

$this->title = '编辑课程分类';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="course-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
