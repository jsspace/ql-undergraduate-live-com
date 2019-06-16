<?php

use yii\widgets\LinkPager;
use backend\models\User;
use backend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', '按月收益明细统计表('.$username.')');

AppAsset::addCss($this,'@web/css/market.css');
?>
<div class="user-view market-earnings-detail market-earnings">
    <div class="direct-income">
        <h5>直接收益</h5>
        <ul class="title">
            <li>头像</li>
            <li>学员姓名</li>
            <li>下单金额</li>
            <li>提成</li>
            <li>下单时间</li>
        </ul>
        <?php foreach ($income as $item) { ?>
            <ul class="detail-content">
                <li><img src="<?= $item['pic'] ?>"></li>
                <li><?= $item['consignee'] ?></li>
                <li><?= $item['order_amount'] ?></li>
                <li><?= $item['income'] ?></li>
                <li><?= $item['pay_time'] ?></li>
            </ul>
        <?php } ?>
    </div>
</div>
