<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CoursePackage */

$this->title = Yii::t('app', 'Create Course Package');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-package-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
