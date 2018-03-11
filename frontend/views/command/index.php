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

$this->title = '课程需求';
?>

<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span>课程需求</span>
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
            <a href="javascript:void(0)" class="study-btn">+ 提交</a>
        </div>
        <div class="study-user-list">
            <p class="title">课程需求</p>
            <ul class="list-ul">
                <?php foreach ($commands as $key => $command) { ?>
                    <li>
                        <p class="user-img">
                            <?php
                                $src = '';
                                if (!empty(User::getUserModel($command->user_id))) {
                                    $src = User::getUserModel($command->user_id)->picture;
                                }
                            ?>
                            <img src="<?= $src ?>"/>
                        </p>
                        <div class="study-content">
                            <!-- <span class="study-title">平面设计课程讲解透彻</span> -->
                            <span class="study-con"><?= $command->content ?></span>
                            <p class="study-user">
                                <span><?= User::item($command->user_id); ?></span>&nbsp;&nbsp;&nbsp;发表于<?= date('Y-m-d H:i:s', $command->create_time); ?>
                            </p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <?php 
                echo LinkPager::widget([
                    'pagination' => $pages,
                    'firstPageLabel'=>'首页',
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
            url: '/command/add',
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
