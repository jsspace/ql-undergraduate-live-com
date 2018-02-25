<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = '班主任详情页';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
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
            //'status',
            [
                'attribute' => 'gender',
                'value'=> $model->gender == 1 ? '女' : '男',
            ],
            'description',
            'unit',
            'office',
            'goodat',
            [
                'attribute'=>'picture',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img($model->picture, ['width' => '100px']);
                }

            ],
            'intro:ntext',
            //'invite',
            'wechat',
            [
                'attribute'=>'wechat_img',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img($model->wechat_img, ['width' => '100px']);
                }

            ],
            'bank',
            'bank_username',
            'bankc_card',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
