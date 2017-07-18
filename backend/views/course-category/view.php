<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-category-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'parent_id',
            'des:ntext',
        ],
    ]) ?>

</div>
