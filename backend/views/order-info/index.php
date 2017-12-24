<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Order Infos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-info-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Order Info'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'order_id',
            'order_sn',
            'consignee',
//             'user_id',
//             'order_status',
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
            // 'pay_id',
            // 'pay_name',
            'goods_amount',
            // 'pay_fee',
            // 'money_paid',
            // 'integral',
            // 'integral_money',
            // 'bonus',
            // 'order_amount',
            'add_time:datetime',
            // 'confirm_time:datetime',
            // 'pay_time:datetime',
            // 'bonus_id',
            // 'is_separate',
            // 'parent_id',
            // 'discount',
            // 'invalid_time:datetime',
            // 'course_ids',
            // 'coupon_ids',
            // 'coupon_money',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
