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

    <h1><?= Html::encode($this->title) ?></h1>

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
            'username',
//             'auth_key',
//             'password_hash',
//             'password_reset_token',
            'email:email',
            'phone',
            'description',
            [
                'attribute' => 'gender',
                'value'=> $model->gender ? '女' : '男',
            ],
            [
                'attribute' => 'picture',
                'label' => '照片',
                'format' => 'raw',
                'value' => Html::img('@web/'.$model->picture, ['width' => 40]),
            ],
//             'unit',
//             'office',
//             'goodat',
//             'intro:ntext',
//             'invite',
//             'status',
            [
                'attribute' => 'created_at',
                'value'=> date('Y-m-d H:i:s', $model->created_at),
            ],
            [
                'attribute' => 'updated_at',
                'value'=> date('Y-m-d H:i:s', $model->updated_at),
            ],
        ],
    ]) ?>

</div>
