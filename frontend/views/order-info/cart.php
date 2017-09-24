<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/order.css');

$this->title = '购物车';
?>
<div class="order-wrapper">
    <div class="step-wrapper">
        <ul class="order-step">
            <li class="step1 active current">
                <i class="icon ion-android-cart"></i>
                <span>我的购物车</span>
            </li>
            <li class="step2">
                <i class="icon ion-document-text"></i>
                <span>确认订单信息</span>
            </li>
            <li class="step3">
                <i class="icon ion-pricetag"></i>
                <span>支付订单</span>
            </li>
        </ul>
    </div>
    <div class="order-cart">
        <div class="cart-thead">
            <span class="select"><input type="checkbox"/>&nbsp;&nbsp;全选</span>
            <span class="delete-all">删除</span>
            <span class="pro-name">课程/商品名称2</span>
            <span class="quantity">数量</span>
            <span class="price">价格</span>
            <span class="operation">操作</span>
        </div>
        <div class="cart-tbody">
            <div class="empty-tbody" style="display: none">
                您的购物车空空如也，想提升自己的技能，赶紧去<a href="/" class="go-link">挑选课程&gt;&gt;</a>
            </div>
            <div class="cart-course-list">
                <ul>
                    <li>
                        <div class="select"><input type="checkbox"/></div>
                        <div class="cart-course-detail">
                            <p class="cart-img">
                                <img src="/img/course-list-img.jpg"/>
                            </p>
                            <p class="cart-txt">
                                <a href="" class="name">前端课程设计</a>
                                <span class="teacher">主讲老师：张老师</span>
                            </p>
                        </div>
                        <div class="cart-quantity">1</div>
                        <div class="cart-price">￥180.00</div>
                        <a href="javascript:void(0)" class="delete-operation">删除</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="cart-tfoot">
            <div class="foot-left">
                <input type="checkbox"/>
                <span>我已同意<a href="">《网站协议》</a></span>
            </div>
            <div class="foot-right">
                <p class="pro-count"><span class="price-high">0</span>件商品</p>
                <p class="pro-count">订单总额<span class="price-high">￥0.00</span></p>
                <a href="javascript:void(0)" class="btn disabled">去结算</a>
            </div>
        </div>
    </div>
</div>