<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;
use backend\models\CoursePackage;
use backend\models\Cities;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Message */

$this->title = '消息详情';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->msg_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->msg_id], [
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
            'msg_id',
            [
                'attribute' => 'publisher',
                'value' => User::item($model->publisher),
            ],
            'content:html',
            [
                'attribute' => 'classids',
                'value' => CoursePackage::namesById($model->classids),
            ],
            [
                'attribute' => 'cityid',
                'value' => function($model) {
                    if ($model->cityid === 'all') {
                        return '全国';
                    } else {
                        return Cities::item($model->cityid);
                    }
                }
            ],
            [
                'attribute' => 'status',
                'value' => Lookup::item('message_status', $model->status),
            ],
            'created_time:datetime',
            'publish_time:datetime',
        ],
    ]) ?>

</div>
