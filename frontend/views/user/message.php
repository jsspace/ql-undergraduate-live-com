<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use backend\models\Member;
use frontend\assets\AppAsset;

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
       <div class="status-select-wrapper _order-status">
            <p class="current-status">全部状态</p>
            <ul class="status-list">
                <li class="active">全部状态</li>
                <li>已读</li>
                <li>未读</li>
            </ul>
        </div>

        <ul class="message-list">
            <li>
                <dl>
                    <dt>
                        <span class="msg-date">2017-12-31 11:22</span>
                        <a href="/user/message/view?id=2299">致所有邢帅教育学员的一封信</a>
                        <span class="unread">未读</span>
                    </dt>
                    <dd>
                        <span class="msg-con">
                        亲爱的学员们：曾经，书信在车马邮件都慢的时代里，哪怕寥寥数语，也是纸短情长。很高...
                        </span>
                        <a class="msg-more" href="/user/message/view?id=2299">查看详细 &gt;</a>
                    </dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>
                        <span class="msg-date">2017-12-31 11:22</span>
                        <a href="/user/message/view?id=2299">致所有邢帅教育学员的一封信</a>
                        <span class="unread">未读</span>
                    </dt>
                    <dd>
                        <span class="msg-con">
                        亲爱的学员们：曾经，书信在车马邮件都慢的时代里，哪怕寥寥数语，也是纸短情长。很高...
                        </span>
                        <a class="msg-more" href="/user/message/view?id=2299">查看详细 &gt;</a>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
</div>