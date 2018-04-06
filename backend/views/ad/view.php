<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Ad */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-view">

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
            //'id',
            'title',
            'url:url',
            [
                'attribute' => 'img',
                'label' => '图片',
                'format' => ['image',['width'=>'40']]
            ],
            [
                'attribute' => 'online',
                'value'=> $model->online == 1 ? '上线' : '下线',
            ],
            [
                'attribute' => 'ismobile',
                'value'=> $model->ismobile == 1 ? '移动' : 'pc',
            ],
            'position',
        ],
    ]) ?>

</div>
