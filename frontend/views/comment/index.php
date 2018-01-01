<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\AppAsset;

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
                <li>
                    <p class="user-img">
                        <img src="/img/user.jpg"/>
                    </p>
                    <div class="study-content">
                        <span class="study-title">平面设计课程讲解透彻</span>
                        <span class="study-con">这门课程从整体结构来说比较简单易懂，每个知识点都概括的非常好，老师最后还会带领大家一块儿复习，并根据实际项目工作经历进行有效理解。</span>
                        <p class="study-user">
                            <span>小蚯蚓</span>&nbsp;&nbsp;&nbsp;发表于2018.01.01
                        </p>
                    </div>
                </li>
                <li>
                    <p class="user-img">
                        <img src="/img/user.jpg"/>
                    </p>
                    <div class="study-content">
                        <span class="study-title">平面设计课程讲解透彻</span>
                        <span class="study-con">这门课程从整体结构来说比较简单易懂，每个知识点都概括的非常好，老师最后还会带领大家一块儿复习，并根据实际项目工作经历进行有效理解。</span>
                        <p class="study-user">
                            <span>小蚯蚓</span>&nbsp;&nbsp;&nbsp;发表于2018.01.01
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
