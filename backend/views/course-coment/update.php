<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseComent */

$this->title = '更新评论';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Coments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="course-coment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
