<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;
use backend\models\CourseComent;

/* @var $this yii\web\View */
/* @var $model backend\models\Command */

$this->title = '课程需求';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="command-view">

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
                'attribute' => 'user_id',
                'value' => User::item($model->user_id),
            ],
            'content:ntext',
            [
                'attribute' => 'ischeck',
                'value'=> CourseComent::item($model->ischeck),
            ],
            'create_time:datetime',
        ],
    ]) ?>

</div>
