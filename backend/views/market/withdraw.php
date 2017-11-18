<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', '提现历史');

?>
<div class="user-view">
    <h1>提现记录</h1>
    <div class="order-table order-history">
        <ul>
            <li>
                <label class="tr-title">提现ID</label>
                <label class="tr-title">提现金额</label>
                <label class="tr-title">提现信息</label>
                <label class="tr-title">提现生成时间</label>
            </li>
            <?php foreach($model as $key=>$val) { ?>
                <li>
                    <span class="tr-title"><?= $val->withdraw_id ?></span>
                    <span class="tr-title"><?= $val->fee ?></span>
                    <span class="tr-title"><?= $val->info ?></span>
                    <span class="tr-title"><?= date('Y-m-d H:i:s', $val->create_time) ?></span>
                </li>
            <?php } ?>
        </ul>
    </div>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
