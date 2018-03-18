<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/order.css');

$this->title = '选择课程';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span><a href="/course/list">课程列表</a></span>
    <span>&gt;</span>
    <span>前端课程设计</span>
</div>
<div class="order-wrapper">
    <div class="course-select">
        <div class="select-container container-course">
            <ul>
                <li>
                    <p class="select-radio">
                        <input type="radio" name="course"/>
                    </p>
                    <p class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </p>
                    <p class="course-detail">
                        <span class="name">前端课程设计</span>
                        <span class="price">价格： ￥<i class="price-num">1800.00</i></span>
                    </p>
                </li>
                <li>
                    <p class="select-radio">
                        <input type="radio" name="course"/>
                    </p>
                    <p class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </p>
                    <p class="course-detail">
                        <span class="name">前端课程设计</span>
                        <span class="price">价格： ￥<i class="price-num">1800.00</i></span>
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="select-container package-select">
        <div class="container-course">
            <h3>购买套餐更核算</h3>
            <ul>
                <li>
                    <p class="select-radio">
                        <input type="radio" name="course"/>
                    </p>
                    <p class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </p>
                    <p class="course-detail">
                        <span class="name">前端课程设计</span>
                        <span class="price">价格： ￥<i class="price-num">1800.00</i></span>
                    </p>
                </li>
                <li>
                    <p class="select-radio">
                        <input type="radio" name="course"/>
                    </p>
                    <p class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </p>
                    <p class="course-detail">
                        <span class="name">前端课程设计</span>
                        <span class="price">价格： ￥<i class="price-num">1800.00</i></span>
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="select-summary">
        <div class="container-course">
            <div class="summary-blank">暂无被选中的课程或套餐</div>
            <div class="summary-section">
                <div class="summary-left">
                    <span class="title">您已选择：</span>
                    <div class="course-list"></div>
                </div>
                <div class="summary-right">
                    <p class="total-price">合计：<span class="price-high">￥<i class="_total-count">1900.00</i></span></p>
                    <a href="JavaScript:void(0)" class="btn add-to-cart"><i class="icon ion-android-cart"></i>加入购物车</a>
                    <a href="" class="btn checkout-btn"><i class="icon ion-pricetag"></i>去结算</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?php echo Url::to('@web/js/order.js');?>"></script>