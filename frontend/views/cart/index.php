<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/order.css');

$this->title = '购物车';
AppAsset::addScript($this,'@web/skin/layer.js');
AppAsset::addScript($this,'@web/js/cart.js');
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
                        $str .= '<div class="select select-course"><input data-courseid="'.$model['course_id'].'" type="checkbox"/></div>';
                        $str .= '<div class="cart-course-detail">';
                        $str .= "<p class='cart-img'><a href='". Url::to(['course/detail', 'courseid' => $model['course_id']])."' target='_blank'><img src='".$model['list_pic']."'/></a></p>";
                        $str .= '<p class="cart-txt">';
                        $str .= "<a href='". Url::to(['course/detail', 'courseid' => $model['course_id']])."' target='_blank' class='name'>".$model['course_name']."</a>";
                        $str .= "<span class='teacher'>主讲老师：".$model['teacher_name']."</span>";
                        $str .= '</p>';
                        $str .= '</div>';
                        $str .= '<div class="cart-quantity">1</div>';
                        $str .= "<div classuse yii\bootstrap\ActiveForm;='cart-price'>￥<span>".$model['discount']."</span></div>";
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
                <input id="access_website_agreement" type="checkbox"/>
                <span>我已同意<a href="">《网站协议》</a></span>
            </div>
            <div class="foot-right">
                <?php $form = ActiveForm::begin(['id' => 'gotobuy-form', 'action' => Url::to(['cart/shopping'])]); ?>
                <p class="pro-count"><span class="price-high course-num">0</span>件商品</p>
                <p class="pro-count">订单总额:￥<span class="price-high course-price">0.00</span></p>
                <?= Html::HiddenInput('course_ids', '', ['id' => 'course_ids']) ?>
                <?= Html::submitButton('去结算', ['class' => 'btn btn-buy disabled']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
