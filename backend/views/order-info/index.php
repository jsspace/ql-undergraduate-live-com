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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Order Info'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            'order_sn',
            'user_id',
            'order_status',
            'pay_status',
            // 'consignee',
            // 'mobile',
            // 'email:email',
            // 'pay_id',
            // 'pay_name',
            // 'goods_amount',
            // 'pay_fee',
            // 'money_paid',
            // 'integral',
            // 'integral_money',
            // 'bonus',
            // 'order_amount',
            // 'add_time:datetime',
            // 'confirm_time:datetime',
            // 'pay_time:datetime',
            // 'bonus_id',
            // 'is_separate',
            // 'parent_id',
            // 'discount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
