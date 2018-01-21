<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Provinces;
use backend\models\Cities;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = '详情';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '学员列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'phone',
            [
                'attribute' => 'provinceid',
                'value' => Provinces::item($model->provinceid),
            ],
            [
                'attribute' => 'cityid',
                'value' => Cities::item($model->cityid),
            ],
            //'status',
            [
                'attribute' => 'gender',
                'value'=> $model->gender == 1 ? '女' : '男',
            ],
            [
                'attribute'=>'picture',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img('/'.$model->picture, ['width' => '100px']);
                }

            ],
            'created_at:datetime',
            'updated_at:datetime',
            //'description',
            //'unit',
            //'office',
            //'goodat',
            //'intro:ntext',
            //'invite',
            //'wechat',
            //'wechat_img',
            //'percentage',
        ],
    ]) ?>

</div>
