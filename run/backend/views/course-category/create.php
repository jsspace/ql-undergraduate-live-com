<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourseCategory */

$this->title = Yii::t('app', 'Create Course Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
