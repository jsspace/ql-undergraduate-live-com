<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\CourseCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\Book */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            //'price',
            //'publisher',
            //'publish_time:datetime',
            //'author',
            [
                'attribute' => 'category',
                'value' => CourseCategory::getNames($model->category),
            ],
            'intro',
            'des:html',
            [
                'attribute' => 'pictrue',
                'label' => '图片',
                'format' => ['image',['width'=>'100']]
            ],
        ],
    ]) ?>

</div>
