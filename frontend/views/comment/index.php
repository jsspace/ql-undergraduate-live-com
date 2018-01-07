<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\AppAsset;
use backend\models\User;
use yii\widgets\LinkPager;

AppAsset::addCss($this,'@web/css/comment.css');

$this->title = '学习感言';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span>学习感言</span>
    </div>
</div>
<div class="container-course">
    <div class="container-inner">
        <div class="study-edit">
            <!-- <p class="study-list">
                <label>标题：</label>
                <input type="text" class="study-input"/>
            </p> -->
            <p class="study-list">
                <label class="con-label">内容：</label>
                <textarea class="study-input"></textarea>
            </p>
            <a href="javascript:void(0)" class="study-btn">+ 发表感言</a>
        </div>
        <div class="study-user-list">
            <p class="title">学员感言</p>
            <ul class="list-ul">
                <?php foreach ($comments as $key => $comment) { ?>
                    <li>
                        <p class="user-img">
                            <img src="<?= User::getUserModel($comment->user_id)->picture; ?>"/>
                        </p>
                        <div class="study-content">
                            <!-- <span class="study-title">平面设计课程讲解透彻</span> -->
                            <span class="study-con"><?= $comment->content ?></span>
                            <p class="study-user">
                                <span><?= User::item($comment->user_id); ?></span>&nbsp;&nbsp;&nbsp;发表于<?= date('Y-m-d H:s:m', $comment->create_time); ?>
                            </p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <?php 
                echo LinkPager::widget([
                    'pagination' => $pages,
                    'firstPageLabel'=>"首页",
                    'lastPageLabel'=>'尾页',
                ]);
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.study-btn').on('click', function() {
        var content = $('.study-input').val();
        $.ajax({
            url: '/comment/add',
            type: 'post',
            dataType:"json",
            data: {
                'content': content,
                '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
            },
            success: function(data) {
                alert(data.message);
                if (data.status === '1') {
                    window.location.reload();
                }
            }
        });
    });
</script>