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
    <span>个人中心</span>
</div>
<div class="user-wrapper">
    <div class="left-menu">
        <div class="topinfo">
            <img src="/img/user.jpg" class="pic">
            <h4 class="name">张三</h4>
            <p class="company">所属企业：<a href="" target="_blank">默认企业</a></p>
            <div class="btn">
                <a href="/user/info"><i class="icon ion-ios-person-outline"></i>个人资料</a>
                <a href="/site/changepwd"><i class="icon ion-edit"></i>修改密码</a>
            </div>
        </div>
        <div class="menu">
            <a href="/user" class="a1 "><i class="icon ion-ios-book-outline"></i>在线课程</a>
            <a href="/user/lives" class="a3 "><i class="icon ion-ios-book-outline"></i>直播课程</a>
            <a href="/user/orders" class="a4 "><i class="icon ion-clipboard"></i>我的订单</a>
            <a href="/user/qnas"><i class="icon ion-ios-help-outline"></i>我的问题</a>
            <a href="/user/coursereviews"><i class="icon ion-ios-star-outline"></i>课程评价</a>
            <a href="/user/teacherreviews"><i class="icon ion-ios-star-outline"></i>教师评价</a>
            <a href="/user/favorites"><i class="icon ion-ios-heart-outline"></i>我的收藏</a>
            <a href="/user/rules"><i class="icon ion-gear-b"></i>管理规定</a>
        </div>
    </div>
    <div class="right-content">
    </div>
</div>