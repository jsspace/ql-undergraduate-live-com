<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Provinces;
use backend\models\Cities;

/* @var $this yii\web\View */
/* @var $model backend\models\ShandongSchool */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shandong Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shandong-school-view">

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
            'id',
            [
                'attribute' => 'provinceid',
                'value' => Provinces::item($model->provinceid),
            ],
            [
                'attribute' => 'cityid',
                'value' => Cities::item($model->cityid),
            ],
            'school_name',
        ],
    ]) ?>

</div>
