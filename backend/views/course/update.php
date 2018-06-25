<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = Yii::t('app', '编辑课程');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->course_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="section course-update">

    <?= $this->render('_form', [
        'model' => $model,
        'teachers' => $teachers,
        'head_teachers' => $head_teachers,
        'categorys' => $categorys
    ]) ?>

</div>
