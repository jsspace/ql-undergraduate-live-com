<?php

use backend\models\Course;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Data */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            [
                'attribute' => 'list_pic',
                'label' => '列表图片',
                'format' => ['image',['width'=>'100']]
            ],
            'summary:ntext',
            'content:html',
            [
                'attribute' => 'course_id',
                'value' => Course::item($model->course_id),
            ],
            'ctime:datetime',
        ],
    ]) ?>

</div>
