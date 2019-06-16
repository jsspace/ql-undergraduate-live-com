<?php

use yii\widgets\LinkPager;
use backend\models\User;
use yii\helpers\Url;
use backend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', '按月收益统计表('.$username.')');

AppAsset::addCss($this,'@web/css/market.css');

?>
<div class="user-view market-earnings teacher-earnings">
    <ul class="title">
        <li>月份</li>
        <li>销售额</li>
        <li>提成</li>
        <li>状态</li>
        <li>操作</li>
    </ul>
    <?php foreach ($income as $item) { ?>
        <ul>
            <li><?= $item['month'] ?></li>
            <li><?= $item['income'] ?></li>
            <li><?= $item['salary'] ?></li>
            <li><?= $item['status'] ?></li>
            <li><a href="<?= Url::to(['teacher/order-detail', 'userid' => $userid, 'month' => $item['month'], 'username' => $username]) ?>">明细</a></li>
        </ul>
    <?php } ?>
</div>
