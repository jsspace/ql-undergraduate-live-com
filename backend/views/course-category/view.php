<?php

use backend\models\CourseCategory;
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
            [
                'attribute' => 'parent_id',
                'value' => function ($model){
                    if ($model->parent_id==0) {
                        return '顶级分类';
                    } else {
                        return CourseCategory::item($model->parent_id);
                    }
                }
            ],
            [
                'attribute' => 'list_icon',
                'label' => '列表图片',
                'format' => ['image',['width'=>'40']]
            ],
            [
                'attribute' => 'detail_icon',
                'label' => '封面图片',
                'format' => ['image',['width'=>'40']]
            ],
            'position',
            'des:ntext',
        ],
    ]) ?>

</div>
