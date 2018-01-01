<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Course;
use backend\models\OrderInfo;
AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
    </div>
</div>
<div class="user-wrapper">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <p class="user-right-title">我的订单</p>
        <?php if (count($all_orders) == 0) { ?>
        <div class="empty-content">您还没有购买任何课程哦~赶紧去<a href="/course/list" class="go-link">挑选课程&gt;&gt;</a></div>
        <?php } else { ?>
            <div class="status-select-wrapper _order-status">
                <p class="current-status">全部状态</p>
                <ul class="status-list">
                    <li class="active" order-status="all">全部状态</li>
                    <li order-status="wait_pay">未付款</li>
                    <li order-status="ing_pay">付款中</li>
                    <li order-status="had_pay">已付款</li>
                </ul>
            </div>
            <ul class="order-list _order-list">
                <?php foreach ($all_orders as $key => $order) {
                    if ($order->pay_status == 0) {
                        $class_tag = 'wait_pay';
                    } else if ($order->pay_status == 1) {
                        $class_tag = 'ing_pay';
                    } else if ($order->pay_status == 2) {
                        $class_tag = 'had_pay';
                    }
                ?>
                    <li class="order-list-item" order-status="<?= $class_tag ?>">
                        <div class="order-title-line">
                            <span class="order-time"><?= date('Y-m-d H:m:s', $order->add_time)  ?></span>
                            <span class="order-number">订单号：<em><?= $order->order_sn ?></em></span>
                            <span class="order-total-money">订单总金额：<?= $order->goods_amount ?></span>
                        </div>
                        <?php 
                            $courseids = $order->course_ids;
                            $courseids_arr = explode(',', $courseids);
                            foreach ($courseids_arr as $key => $courseid) {
                                $course = Course::find()
                                ->where(['id' => $courseid])
                                ->one();
                           if ($course) {
                            ?>
                            <div class="order-content">
                                <p class="course-img"><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"><img src="<?= $course->list_pic ?>"/></a></p>
                                <p class="course-name"><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"><?= $course->course_name ?></a></p>
                                <p class="course-quantity">&times; 1</p>
                                <p class="order-price">
                                    <span class="total-price">总额：￥<?= $course->discount ?></span>
                                    <span class="pay-method">在线支付</span>
                                </p>
                                <p class="order-status"><?= OrderInfo::item($order->pay_status); ?></p>
                            </div>
                        <?php } } ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>

<script>
    $(function() {
        $("._order-status .status-list li").each(function() {
            $(this).on("click", function() {
                var orderStatus = $(this).attr("order-status");
                $(this).addClass("active").siblings("li").removeClass("active");
                $(".current-status").text($(this).text());
                if (orderStatus === "all") {
                    $("._order-list li").show();
                } else {
                    $("._order-list li").hide();
                    $("._order-list li[order-status='" + orderStatus +"']").show();
                }
            });
        });
    });
</script>