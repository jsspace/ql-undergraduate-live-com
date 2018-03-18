<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourseNews */

$this->title = Yii::t('app', 'Create Course News');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-news-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
