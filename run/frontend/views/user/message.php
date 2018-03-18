<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Member;
use frontend\assets\AppAsset;
use backend\models\Message;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
    </div>
</div>
<div class="user-wrapper">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
       <p class="user-right-title">消息通知</p>
       <!-- <div class="status-select-wrapper _order-status">
            <p class="current-status">全部状态</p>
            <ul class="status-list">
                <li class="active">全部状态</li>
                <li>已读</li>
                <li>未读</li>
            </ul>
        </div> -->

        <ul class="message-list">
            <?php
                foreach ($messages as $key => $read) {
                    $message = Message::getMessage($read->msg_id);
                ?>
                    <li>
                        <dl>
                            <dt>
                                <span class="msg-date"><?= date('Y-m-d H:i:s', $read->get_time) ?></span>
                                <a href="/user/message-view?id=<?= $read->id ?>"><?= $message->title ?></a>
                                <?php if ($read->status == 0) { ?>
                                    <span class="unread">未读</span>
                                <?php } ?>
                            </dt>
                            <dd>
                                <span class="msg-con">
                                <?php
                                    $content = substr($message->content , 0 , 200);
                                    $content=str_replace("\n","",$content);
                                    echo $content;
                                ?>
                                </span>
                                <a class="msg-more" href="/user/message-view?id=<?= $read->id ?>">查看详细 &gt;</a>
                            </dd>
                        </dl>
                    </li>
           <?php } ?>
        </ul>
    </div>
</div>