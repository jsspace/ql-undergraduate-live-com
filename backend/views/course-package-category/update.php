<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CoursePackageCategory */

$this->title = '编辑套餐分类';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Package Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="course-package-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
