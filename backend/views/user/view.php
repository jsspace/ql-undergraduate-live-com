<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'value'=> $model->status == 1 ? '已激活' : '未激活',
            ],
            'created_at',
            'updated_at',
            'phone',
            [
                'attribute' => 'gender',
                'value'=> $model->gender == 1 ? '男' : '女',
            ],
            'description',
            'unit',
            'office',
            'goodat',
            'picture',
            'intro:ntext',
            'invite',
            'wechat',
            'wechat_img',
            'percentage',
        ],
    ]) ?>

</div>
