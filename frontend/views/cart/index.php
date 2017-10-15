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
            <span class="select"><input class="checkbox-selectAll _checkbox-selectAll" type="checkbox"/>&nbsp;&nbsp;全选</span>
            <span class="delete-all _delete-all">删除</span>
            <span class="pro-name">课程/商品名称</span>
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
                <?php 
                    $str = '';
                    foreach($models as $model) {
                        $str .= '<li>';
                        $str .= '<input type="hidden" value="'.$model['course_id'].'" />';
                        $str .= '<div class="select"><input type="checkbox"/></div>';
                        $str .= '<div class="cart-course-detail">';
                        $str .= "<p class='cart-img'><a href='". Url::to(['course/detail', 'courseid' => $model['course_id']])."' target='_blank'><img src='".$model['list_pic']."'/></a></p>";
                        $str .= '<p class="cart-txt">';
                        $str .= "<a href='". Url::to(['course/detail', 'courseid' => $model['course_id']])."' target='_blank' class='name'>".$model['course_name']."</a>";
                        $str .= "<span class='teacher'>主讲老师：".$model['teacher_name']."</span>";
                        $str .= '</p>';
                        $str .= '</div>';
                        $str .= '<div class="cart-quantity">1</div>';
                        $str .= "<div class='cart-price'>￥<span>".$model['price'] * $model['discount']."</span></div>";
                        $str .= '<a href="javascript:void(0)" class="delete-operation _delete-operation">删除</a>';
                        $str .= '</li>';
                    }
                    echo $str;
                ?>
                </ul>
            </div>
        </div>
        <div class="cart-tfoot">
            <div class="foot-left">
                <input type="checkbox"/>
                <span>我已同意<a href="">《网站协议》</a></span>
            </div>
            <div class="foot-right">
                <p class="pro-count"><span class="price-high course-num">0</span>件商品</p>
                <p class="pro-count">订单总额:￥<span class="price-high course-price">0.00</span></p>
                <a href="javascript:void(0)" class="btn disabled">去结算</a>
            </div>
        </div>
    </div>
</div>
<script src="<?= Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script src="<?= Url::to('@web/js/cart.js');?>"></script>