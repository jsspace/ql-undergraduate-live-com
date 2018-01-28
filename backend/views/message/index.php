<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\User;
use backend\models\CoursePackage;
use backend\models\Cities;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;

$userModels = User::users('student');
$ids = array_keys($userModels);
print_r($ids);
die();
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

            'msg_id',
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
            'publish_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
