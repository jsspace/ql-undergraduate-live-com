<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
</div>
<div class="user-wrapper">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <p class="user-right-title">我的课程</p>
        <ul class="user-course-list">
            <li>
                <a href="" class="user-course-img"><img src="/img/course-list-img.jpg"/></a>
                <div class="user-course-details">
                    <h3><a href="http://gkk.xsteach.com/course/view?gid=38" title="玩转PS" target="_blank">玩转PS</a></h3>
                    <div class="row">主讲老师: 孙峰</div>
                    <div class="row">
                        <div class="btns">
                            <a class="btn btn-primary" target="_blank" href="http://gkk.xsteach.com/course/view?gid=38">进入学习</a>
                            <a class="btn btn-default unfavorite" href="javascript:;" data-id="38" data-favor="1">取消收藏</a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a href="" class="user-course-img"><img src="/img/course-list-img.jpg"/></a>
                <div class="user-course-details">
                    <h3><a href="http://gkk.xsteach.com/course/view?gid=38" title="玩转PS" target="_blank">玩转PS</a></h3>
                    <div class="row">主讲老师: 孙峰</div>
                    <div class="row">
                        <div class="btns">
                            <a class="btn btn-primary" target="_blank" href="http://gkk.xsteach.com/course/view?gid=38">进入学习</a>
                            <a class="btn btn-default unfavorite" href="javascript:;" data-id="38" data-favor="1">取消收藏</a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a href="" class="user-course-img"><img src="/img/course-list-img.jpg"/></a>
                <div class="user-course-details">
                    <h3><a href="http://gkk.xsteach.com/course/view?gid=38" title="玩转PS" target="_blank">玩转PS你说我说大家说说啥好呢不知道</a></h3>
                    <div class="row">主讲老师: 孙峰</div>
                    <div class="row">
                        <div class="btns">
                            <a class="btn btn-primary" target="_blank" href="http://gkk.xsteach.com/course/view?gid=38">进入学习</a>
                            <a class="btn btn-default unfavorite" href="javascript:;" data-id="38" data-favor="1">取消收藏</a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a href="" class="user-course-img"><img src="/img/course-list-img.jpg"/></a>
                <div class="user-course-details">
                    <h3><a href="http://gkk.xsteach.com/course/view?gid=38" title="玩转PS" target="_blank">玩转PS你说我说大家说说啥好呢不知道</a></h3>
                    <div class="row">主讲老师: 孙峰</div>
                    <div class="row">
                        <div class="btns">
                            <a class="btn btn-primary" target="_blank" href="http://gkk.xsteach.com/course/view?gid=38">进入学习</a>
                            <a class="btn btn-default unfavorite" href="javascript:;" data-id="38" data-favor="1">取消收藏</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>