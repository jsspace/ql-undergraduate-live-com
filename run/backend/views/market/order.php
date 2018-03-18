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
                    <span class="tr-title"><a href="/order-info/view?id=<?= $val->order_id ?>" target="_blank"><?= $val->order_sn ?></a></span>
                    <span class="tr-title"><?= $val->goods_amount ?></span>
                    <span class="tr-title"><a href="/student/<?= $val->user_id ?>" target="_blank"><?= User::item($val->user_id); ?></a></span>
                    <span class="tr-title"><?= date('Y-m-d H:i:s', $val->add_time) ?></span>
                </li>
            <?php } ?>
        </ul>
    </div>
    <?= LinkPager::widget(['pagination' => $pages]); ?>

	<div>市场专员报酬 = 本区域订单×提成比例 提成比例初定为50%</div>
    <div>总收入：<?= $market_total_income; ?></div>
    <div>已提现金额：<?= $total_withdraw; ?></div>
</div>
