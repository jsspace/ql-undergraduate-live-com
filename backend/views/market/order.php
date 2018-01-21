<?php

use yii\widgets\LinkPager;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', '订单记录');
?>
<div class="user-view">
    <div class="order-table order-history">
        <ul>
            <li>
                <label class="tr-title">订单号</label>
                <label class="tr-title">商品总金额</label>
                <label class="tr-title">用户ID</label>
                <label class="tr-title">订单生成时间</label>
            </li>
            <?php foreach($model as $key=>$val) { ?>
                <li>
                    <span class="tr-title"><?= $val->order_sn ?></span>
                    <span class="tr-title"><?= $val->goods_amount ?></span>
                    <span class="tr-title"><a href="/student/<?= $val->user_id ?>" target="_blank"><?= User::item($val->user_id); ?></a></span>
                    <span class="tr-title"><?= date('Y-m-d H:i:s', $val->add_time) ?></span>
                </li>
            <?php } ?>
        </ul>
    </div>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
