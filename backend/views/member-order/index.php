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
            // 'order_amount',
            // 'add_time',
            // 'end_time',
            // 'pay_time',
            // 'discount',
            // 'invalid_time',
            // 'member_id',

           [
                'class' => 'yii\grid\ActionColumn',
//                 'header' => '操作',
                'template' => '{view}',
           ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
