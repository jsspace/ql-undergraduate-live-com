<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Member Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a(Yii::t('app', 'Create Member Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'order_id',
            'order_sn',
            'pay_id',
//             'user_id',
            'consignee',
            [
                'attribute' => 'order_status',
                'value' => function ($model) {
                $status = '';
                if ($model->order_status ==  0) {
                    $status = '未确认';
                } elseif ($model->order_status ==  1) {
                    $status = '已确认';
                } elseif ($model->order_status ==  2) {
                    $status = '已取消';
                } elseif ($model->order_status ==  3) {
                    $status = '无效';
                } elseif ($model->order_status ==  4) {
                    $status = '退货';
                }
                return $status;
            },
            'filter'=>[0 => '未确认',1 => '已确认', 2 => '已取消', 3 => '无效', 4 => '退货'],
            ],
            [
                'attribute' => 'pay_status',
                'value' => function ($model) {
                    $status = '';
                    if ($model->pay_status ==  0) {
                        $status = '未付款';
                    } elseif ($model->pay_status ==  1) {
                        $status = '付款中';
                    } elseif ($model->pay_status ==  2) {
                        $status = '已付款';
                    }
                    return $status;
                },
                'filter'=>[0 => '未付款',1 => '付款中', 2 => '已付款'],
            ],
            // 'mobile',
            // 'email:email',
            // 'pay_name',
            'goods_amount',
            // 'pay_fee',
            // 'money_paid',
            // 'order_amount',
            'add_time:datetime',
            // 'pay_time:datetime',
            // 'discount',
            // 'invalid_time:datetime',

           [
                'class' => 'yii\grid\ActionColumn',
//                 'header' => '操作',
                'template' => '{view}',
           ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
