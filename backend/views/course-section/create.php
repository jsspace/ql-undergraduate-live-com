<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourseSection */

$this->title = Yii::t('app', 'Create Course Section');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
