<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\models\User;
use backend\models\CoursePackage;
use backend\models\Cities;
use backend\models\Lookup;
use backend\models\OrderGoods;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
$isadmin = User::isAdmin(Yii::$app->user->id);
?>
<div class="message-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Message'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if ($model->status == 0 || $model->status == 2) {
                            $options = array_merge([
                                    'title' => Yii::t('yii', 'Update'),
                                    'aria-label' => Yii::t('yii', 'Update'),
                                    'data-pjax' => '0',
                            ]);
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                        } else {
                            return '';
                        }
                    },
                    'delete' => function ($url, $model, $key) {
                        if ($model->status == 0 || $model->status == 2) {
                            $options = array_merge([
                                    'title' => Yii::t('yii', 'Delete'),
                                    'aria-label' => Yii::t('yii', 'Delete'),
                                    'data-pjax' => '0',
                            ]);
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                        } else {
                            return '';
                        }
                    },
                ],
            ],
            //'msg_id',
            [
                'label'=>'审核',
                'format'=>'raw',
                'value' => function($model){
                    if ($model->status == 0) {
                        $url = Url::to(['message/review', 'msg_id' => $model->msg_id]);
                        return Html::a('审核通过', $url);
                    } else if ($model->status == 1) {
                        return '已通过';
                    } else {
                        return '审核未通过';
                    }
                },
                'visible' => intval($isadmin) == 1
            ],
            [
                'attribute' => 'publisher',
                'value'=> function ($model) {
                    return User::item($model->publisher);
                }
            ],
            'title',
            //'content:ntext',
            [
                'attribute' => 'classids',
                'value' => function ($model) {
                    return CoursePackage::namesById($model->classids);
                }
            ],
            [
                'attribute' => 'cityid',
                'value' => function($model) {
                    if ($model->cityid === 'all') {
                        return '全国';
                    } else {
                        return Cities::item($model->cityid);
                    }
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Lookup::item('message_status', $model->status);
                },
                'filter' => Lookup::items('message_status'),
            ],
            'created_time:datetime',
            //'publish_time:datetime'
        ],
    ]); ?>
</div>
