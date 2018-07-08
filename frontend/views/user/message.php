<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Member;
use frontend\assets\AppAsset;
use backend\models\Message;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心-消息';
?>

<div class="htcontent">
    <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">我的消息</a></h2>
    <div class="htbox2">
        <div class="httxt1 cc">
            <h3 class="ht_tt1">消息列表</h3>
            <?php if (count($messages) == 0) { ?>
            <div class="empty-content">您还没有消息</div>
            <?php } else { ?>
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
            <?php } ?>
        </div>
    </div>
</div>