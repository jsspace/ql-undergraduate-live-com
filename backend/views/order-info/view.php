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
    <div class="order-table">
        <ul>
            <li>
                <label class="tr-title">订单号</label>
                <span class="tr-content"><?= $model->order_sn; ?></span>
            </li>
            <li>
                <label class="tr-title">姓名</label>
                <span class="tr-content"><?= $model->consignee; ?></span>
            </li>
            <li>
                <label class="tr-title">邮箱</label>
                <span class="tr-content"><?= $model->email; ?></span>
            </li>
            <li>
                <label class="tr-title">手机号</label>
                <span class="tr-content"><?= $model->mobile; ?></span>
            </li>
            <li>
                <label class="tr-title">支付状态</label>
                <span class="tr-content"><?= $model->pay_status; ?></span>
            </li>
            <li>
                <label class="tr-title">商品总金额</label>
                <span class="tr-content"><?= $model->goods_amount; ?></span>
            </li>
            <li>
                <label class="tr-title">应付款总金额</label>
                <span class="tr-content"><?= $model->order_amount; ?></span>
            </li>
            <li>
                <label class="tr-title">优惠券金额</label>
                <span class="tr-content"><?= $model->coupon_money; ?></span>
            </li>
        </ul>
    </div>
    <div class="order-table order-course-info">
        <p class="title">购买课程详情</p>
        <ul>
            <li class="info-th">
                <span class="tr-title">课程</span>
                <span class="tr-content">价格</span>
            </li>
            <?php foreach ($courses as $course) { ?>
                <li>
                    <span class="tr-title"><?= $course->course_name ?></span>
                    <span class="tr-content"><?= $course->discount ?></span>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
