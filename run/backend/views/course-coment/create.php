<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourseComent */

$this->title = Yii::t('app', 'Create Course Coment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Coments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-coment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
