<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AudioCategory;
/* @var $this yii\web\View */
/* @var $model backend\models\Audio */

$this->title = $model->des;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audio-view">
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
            'des',
            [
                'attribute' => 'pic',
                'label' => '列表图片',
                'format' => ['image',['width'=>'100']]
            ],
            [
                'attribute' => 'category_id',
                'value' => AudioCategory::item($model->category_id),
            ],
            'click_time',
            'create_time:datetime',
        ],
    ]) ?>

</div>
