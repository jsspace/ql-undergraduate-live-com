<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourseChapter */

$this->title = Yii::t('app', 'Create Course Chapter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Chapters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-chapter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
