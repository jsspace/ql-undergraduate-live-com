<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/order.css');

$this->title = '订单详情';
AppAsset::addScript($this,'@web/js/shopping.js?v='.time());
?> 
<div class="order-wrapper order-detail-section">
    <div class="step-wrapper">
        <ul class="order-step">
            <li class="step1 finished">
                <i class="icon ion-ios-checkmark-empty"></i>
                <span>我的购物车</span>
            </li>
            <li class="step2 current">
                <i class="icon ion-document-text"></i>
                <span>确认订单信息</span>
            </li>
            <li class="step3">
                <i class="icon ion-pricetag"></i>
                <span>支付订单</span>
            </li>
        </ul>
    </div>
    <div class="order-detail-wrapper">
        <div class="order-top">
            <div class="inner-order">
                <h3>订单详情</h3>
                <p class="order-txt">订单编号：&nbsp;&nbsp;&nbsp;&nbsp;<?= $order_sn ?></p>
                <p class="order-txt">订单内容：</p>
                <ul class="order-list">
                <?php 
                    $total_price = 0.00;
                    foreach($course_models as $model) { 
                        $total_price += $model->discount;
                ?>
                    <li class="course">
                        <div class="cart-course-detail">
                            <div class="cart-img">
                                <img src="<?= $model->list_pic; ?>"/>
                            </div>
                            <div class="cart-txt">
                                <span class="name"><?= $model->course_name ?></span>
                                <span class="price">价格：￥<?= $model->discount ?></span>
                            </div>
                        </div>
                    </li>
                 <?php }
                    foreach($course_package_models as $model) { 
                        $total_price += $model->discount;
                ?>
                    <li class="course">
                        <div class="cart-course-detail">
                            <div class="cart-img">
                                <img src="<?= $model->list_pic; ?>"/>
                            </div>
                            <div class="cart-txt">
                                <span class="name"><?= $model->name ?></span>
                                <span class="price">价格：￥<?= $model->discount ?></span>
                            </div>
                        </div>
                    </li>
                 <?php }?>
                </ul>
                <p class="total-summary">订单总额：<span class="price-high">￥<?= $total_price ?></span></p>
            </div>
        </div>
        <div class="order-payment-method">
            <div class="inner-order">
                <h3>订单支付方式</h3>
                <div class="payment-method">
                    <input type="radio" name="payment-method" checked="checked" />
                    <span>在线支付</span>
                    <span class="payment-desc"> 在线支付成功后，系统自动为您开通课程权限。</span>
                </div>
            </div>
        </div>
        <div class="order-payment-method discount">
            <div class="inner-order">
                <h3>赠品</h3>
                <div class="discount-con">
                    <div class="tab-title">
                        <span>请前往个人中心填写有效收获地址~</span>
                    </div>
                    <ul class="tab-con">
                        <?php if (in_array("22", $category_ids) || !empty($course_package_ids)) { ?>
                            <li class="select">
                                <input type="checkbox" class="gift-book" value="语文" />&nbsp;&nbsp;
                                <img src="/img/gitf-chinese.png">
                                <p>大学语文一本通</p>
                            </li>
                        <?php } ?>
                        <?php if (in_array("23", $category_ids) || !empty($course_package_ids)) { ?>
                        <li class="select">
                            <input type="checkbox" class="gift-book" value="数学" />&nbsp;&nbsp;
                            <img src="/img/gift-math.png">
                            <p>高等数学一本通</p>
                        </li>
                        <?php } ?>
                        <?php if (in_array("24", $category_ids) || !empty($course_package_ids)) { ?>
                        <li class="select">
                            <input type="checkbox" class="gift-book" value="英语" />&nbsp;&nbsp;
                            <img src="/img/gift-english.png">
                            <p>英语一本通</p>
                        </li>
                        <?php } ?>
                        <?php if (in_array("25", $category_ids) || !empty($course_package_ids)) { ?>
                        <li class="select">
                            <input type="checkbox" class="gift-book" value="计算机" />&nbsp;&nbsp;
                            <img src="/img/gift-computer.png">
                            <p>计算机一本通</p>
                        </li>
                        <?php } ?>
                        <!-- <li>
                            <?php if (empty($coupons)) {?>
                            <div class="no-discount">暂无可使用优惠券</div>
                            <?php } else {?>
                            <ul class="discount-list">
                            	<?php foreach ($coupons as $coupon) {?>
                                <li>
                                    <input type="radio" data-couponid="<?= $coupon->coupon_id ?>" name="discount"/>
                                    <span class="discount-bg _discount-fee" discount-fee="<?= $coupon->fee ?>">￥<?= $coupon->fee ?></span>
                                    <span class="discount-desc"><?= $coupon->name ?></span>
                                </li>
                                <?php }?>
                            </ul>
                            <?php }?>
                        </li> -->
                    </ul>
                    <div class="tab-con tab-con-coin">
                        <input type="checkbox" />&nbsp;&nbsp;
                        <span><label><?=$displayCoins ?></label>金币</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-payment-method order-total">
            <div class="inner-order">
                <div class="left">
                    <span>订单总额： ￥<?= $total_price ?></span>
                    <span class="discount-price _discount-price">已优惠：<i></i></span>
                </div>
                <div class="right">
                    <?php $form = ActiveForm::begin(['id' => 'order-confirm-form', 'action' => Url::to(['order-info/confirm_order','order_sn' => $order_sn])]); ?>
                    应付总额：<span class="price-high">￥<span class="_total-price"><?= $total_price ?></span></span>
                    <?= Html::HiddenInput('course_package_ids', $course_package_ids, ['id' => 'course_package_ids']) ?>
                    <?= Html::HiddenInput('course_ids', $course_ids, ['id' => 'course_ids']) ?>
                    <input type="hidden" name="gift_books" class="gift_books" value="">
                    <input type="hidden" name="gift_coins" class="gift_coins" value="0">
                    <?= Html::HiddenInput('coupon_ids', '', ['id' => 'coupon_ids']) ?>
                    <?= Html::submitButton('提交订单', ['class' => 'btn btn-confirm']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /*$(function () {
        $('.order-payment-method .tab-title span').each(function (index) {
            $(this).on('click', function () {
                $(this).addClass('active').siblings('span').removeClass('active');
                $('.order-payment-method .tab-con li').eq(index).show().siblings('li').hide();
            });
        });
    });
    $('.select-wallet').on('click', function(){
        if ($(this).is(':checked')) {
            $('._use_wallet').val(1);
        } else {
            $('._use_wallet').val(0);
        }
    });*/
    $('.gift-book').on('click', function () {
        $('.gift_books').val('');
        $('.gift-book').each(function() {
            if ($(this).is(':checked')) {
                $('.gift_books').val($('.gift_books').val() +','+ $(this).val())
            }
        })
        if (this.checked) {
            $('.tab-con-coin label').text(Number($('.tab-con-coin label').text()) - 100);
        } else {
            $('.tab-con-coin label').text(Number($('.tab-con-coin label').text()) + 100);
        }
    })
    $('.tab-con-coin input').on('click', function() {
        if ($(this).is(':checked')) {
            $('.gift_coins').val(Number($('.tab-con-coin label').text()))
        } else {
            $('.gift_coins').val(0)
        }
    })
</script>