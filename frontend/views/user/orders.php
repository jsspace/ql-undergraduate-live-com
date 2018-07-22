<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Course;
use backend\models\OrderInfo;
use backend\models\OrderGoods;
/*use backend\models\CoursePackage;*/

$this->title = '我的订单';
?>
<div class="htcontent">
    <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">我的订单</a></h2>
    <div class="status-select-wrapper _order-status">
        <p class="current-status">全部状态</p>
        <ul class="status-list">
            <li class="active" order-status="all">全部状态</li>
            <li order-status="wait_pay">未付款</li>
            <li order-status="ing_pay">付款中</li>
            <li order-status="had_pay">已付款</li>
        </ul>
    </div>
    <div class="htbox2">
        <div class="right-content">
            <?php if (count($all_orders) == 0) { ?>
            <div class="empty-content">您还没有购买任何课程哦~赶紧去<a href="/course/list" class="go-link">挑选课程&gt;&gt;</a></div>
            <?php } else { ?>
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
                                <span class="order-time"><?= date('Y-m-d H:i:s', $order->add_time)  ?></span>
                                <span class="order-number">订单号：<em><?= $order->order_sn ?></em></span>
                                <span class="order-total-money">订单总金额：<?= $order->goods_amount ?></span>
                            </div>
                            <?php 
                                $courseids = $order->course_ids;
                                $courseids_arr = explode(',', $courseids);
                                
                                $goods_items_models = OrderGoods::find()
                                ->where(['order_sn' => $order->order_sn])
                                ->all();
                                
                                foreach ($goods_items_models as $goods_item) {
                                    if ($goods_item->type == 'course') {
                                        $course = Course::find()
                                        ->where(['id' => $goods_item->goods_id])
                                        ->one();
                                        $course_name = $course->course_name;
                                    }/* else if ($goods_item->type == 'course_package') { 
                                        $course = CoursePackage::find()
                                        ->where(['id' => $goods_item->goods_id])
                                        ->one();
                                        $course_name = $course->name;
                                    }*/
                                    
                               if ($course) {
                                ?>
                                <div class="order-content">
                                    <p class="course-img"><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"><img src="<?= $course->list_pic ?>"/></a></p>
                                    <p class="course-name"><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"><?= $course_name ?></a></p>
                                    <p class="course-quantity">&times; 1</p>
                                    <p class="order-price">
                                        <span class="total-price">总额：￥<?= $course->discount ?></span>
                                        <span class="pay-method">在线支付</span>
                                    </p>
                                    <p class="order-status"><?= OrderInfo::item($order->pay_status); ?></p>
                                    <?php 
                                        if ($order->pay_status != 2) { ?>
                                            <p class="order-status"><a target="_blank" href="<?= Url::to(['order-info/confirm_order', 'order_sn' => $order->order_sn]) ?>">去支付</a></p>
                                    <?php } ?>
                                </div>
                            <?php } } ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
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
</body>
</html>
