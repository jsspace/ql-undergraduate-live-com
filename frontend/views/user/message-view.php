<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Member;
use frontend\assets\AppAsset;
use backend\models\Message;
use backend\models\User;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="user-wrapper">
    <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="/user/message">我的消息</a></h2>
    <div class="right-content">
       <?php
            $message = Message::getMessage($read->msg_id);
        ?>
       <p class="user-right-title">消息详情
            <a href="/user/message">返回消息通知&gt;</a>
       </p>
       <div class="message-detail">
            <span class="avt">
                <img src="<?= User::getUserModel($message->publisher)->picture; ?>" title="<?= User::getUserModel($message->publisher)->username; ?>">
            </span>
            <dl>
                <dt><?= $message->title ?></dt>
                <dd class="msg-info">
                    <span class="author"><?= User::getUserModel($message->publisher)->username; ?></span>&nbsp;&nbsp;
                    <span class="msg-date">发表于&nbsp;<?= date('Y-m-d H:i:s', $read->get_time) ?></span>
                </dd>
                <dd class="content" id="content-detail">
                    <?= $message->content ?>
                </dd>
            </dl>
       </div>
    </div>
</div>