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
            ['class' => 'yii\grid\ActionColumn'],
            //'msg_id',
            [
                'label'=>'审核',
                'format'=>'raw',
                'value' => function($model){
                    if ($model->status != 1) {
                        $url = Url::to(['message/review', 'msg_id' => $model->msg_id]);
                        return Html::a('审核通过', $url);
                    } else {
                        return '已处理';
                    }
                }
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