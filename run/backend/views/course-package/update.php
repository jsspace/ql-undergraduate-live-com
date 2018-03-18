<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CoursePackage */

$this->title = Yii::t('app', '编辑套餐');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="course-package-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
