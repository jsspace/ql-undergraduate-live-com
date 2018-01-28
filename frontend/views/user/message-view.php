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
       <p class="user-right-title">消息详情
            <a href="/user/message">返回消息通知&gt;</a>
       </p>
       <div class="message-detail">
            <span class="avt">
                <img src="http://www.xsteach.com/static/images/user_img.png" alt="憨憨熊" title="憨憨熊">
            </span>
            <dl>
                <dt>【紧急通知】50天逆袭，躁动的你一起来吧</dt>
                <dd class="msg-info">
                    <span class="author">作者姓名</span>&nbsp;&nbsp;
                    <span class="msg-date">发表于&nbsp;2017-10-21</span>
                </dd>
                <dd class="content" id="content-detail">
                    <p><span style="color: rgb(227, 108, 9);"><strong>亲爱的童鞋：</strong></span></p><p>学习不苦 坚持很酷</p><p>用心去做 永不浪费</p><p>充电50天 人生大改变</p><p>精英们已经开始1周的学习了，你是不是下一个跨界大咖？</p><p>人生大改变：50天逆袭训练营成长 <a href="http://event.xsteach.com/strikes-back/activity" target="_self">http://event.xsteach.com/strikes-back/activity</a><br></p><p><a href="http://event.xsteach.com/strikes-back/activity" target="_self"><a href="http://f.cdn.xsteach.cn/uploaded/df/99/6c/df996cdcdd2588ebada9ed9181037042002.png" '="" target="_blank"><img src="http://f.cdn.xsteach.cn/uploaded/df/99/6c/df996cdcdd2588ebada9ed9181037042002.png" style="max-width: 100%;"></a></a></p>
                </dd>
            </dl>
       </div>
    </div>
</div>