<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseNews */

$this->title = '编辑新闻';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="course-news-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
