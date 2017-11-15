<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderInfo */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-info-view">

    <h1><?= Html::encode($this->title) ?></h1>
订单号：<?= $model->order_sn; ?>
姓名：<?= $model->consignee; ?>
邮箱：<?= $model->email; ?>
手机号：<?= $model->mobile; ?>
支付状态：<?= $model->pay_status; ?>
商品总金额：<?= $model->goods_amount; ?>
应付款总金额：<?= $model->order_amount; ?>
优惠券金额：<?= $model->coupon_money; ?>

<table>
<tr><th>课程名</th><th>价格</th></tr>
<?php 
$str = '';
foreach ($courses as $course) {
    $str .= "<tr><th>$course->course_name</th><th>$course->discount</th></tr>";
}
echo $str;
?>
</table>

</div>
