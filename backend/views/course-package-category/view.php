<?php

use backend\models\CoursePackageCategory;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CoursePackageCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course Package Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-package-category-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'parent_id',
                'value' => function ($model){
                    if ($model->parent_id==0) {
                        return '顶级分类';
                    } else {
                        return CoursePackageCategory::item($model->parent_id);
                    }
                }
            ],
            'des:ntext',
        ],
    ]) ?>

</div>
