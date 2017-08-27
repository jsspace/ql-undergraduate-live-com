<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CoursePackageCategory */

$this->title = Yii::t('app', 'Create Course Package Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Package Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-package-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
