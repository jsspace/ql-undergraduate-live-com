<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;

AppAsset::addCss($this,'@web/css/user.css');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>个人中心</title>
    <meta name="description" content="个人中心"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="/css/htmain.css" type="text/css" media="screen"/>
</head>
<body>
<div id="httop" class="colorfff cc">
    <h1><a href="/"><img src="/images/htlogo.png"/></a></h1>
    <ul>
        <li><a href="#"><img src="/images/hticon1.png"/>我的课表</a></li>
        <li><a href="#"><img src="/images/hticon1a.png"/>热门班级</a></li>
        <li><a href="/course/open"><img src="/images/hticon1b.png"/>公开课</a></li>
        <li><a href="#"><img src="/images/hticon1c.png"/>个人资料</a></li>
        <li><a href="/about/how-to-study"><img src="/images/hticon1d.png"/>如何上课</a></li>
        <li><a href="#"><img src="/images/hticon1e.png"/>问老师</a></li>
    </ul>
    <dl>
        <dd class="hthome"><img src="/images/htpic1.png" width="60" height="60"/><span><p><a href="#"><?= Yii::$app->
            user->identity->username || '尊敬的用户' ?></a></p><p><a href="/">官网首页</a></p></span></dd>
        <dd class="htxx"><a href="/user/message"><img src="/images/hticon2.png"/>消息<code>8</code></a></dd>
        <dd class="htexit"><a href="<?= Url::to(['site/logout']) ?>"><img src="/images/hticon2a.png"/>退出</a></dd>
    </dl>
</div>
<div id="htbox">
    <div class="htsidebar">
        <h3 class="colorfff">个人中心</h3>
        <ul>
            <li><a href="/user/info"><span><img src="/images/hticon3.png"/><cite><img
                    src="/images/hticon3a.png"/></cite></span>我的班级</a></li>
            <li class="htleftnow"><a href="/user/orders"><span><img src="/images/hticon4.png"/><cite><img
                    src="/images/hticon4a.png"/></cite></span>我的订单</a></li>
            <li><a href="/user/favorite"><span><img src="/images/hticon6.png"/><cite><img
                    src="/images/hticon6a.png"/></cite></span>我的收藏</a></li>
            <li><a href="/user/coupon"><span><img src="/images/hticon7.png"/><cite><img
                    src="/images/hticon7a.png"/></cite></span>我的奖励</a></li>
            <li><a href="#"><span><img src="/images/hticon9.png"/><cite><img src="/images/hticon9a.png"/></cite></span>邀请好友</a>
            </li>
        </ul>
        <dl>
            <dt>
                <h4><a href="/about/start-guid">开学指导</a></h4>
                <h4><a href="/about/student-book">学员手册</a></h4>
                <h5>常见问题</h5>
                <p><a href="/about/faq">?问题1</a></p>
                <p><a href="/about/faq">?问题2</a></p>
                <p><a href="/about/faq">?问题3</a></p>
            </dt>
            <dd>
                <h4><img src="/images/htwxicon1.png"/>微信客服</h4>
                <p><img src="/images/kefu-erweima.jpg"/></p>
            </dd>
        </dl>
    </div>
    <div class="htcontent">
        <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">我的班级</a></h2>
        <div class="htbox2">
            <div class="httxt1 cc">
                <h3 class="ht_tt1">我的订单</h3>
                <?php if (count($all_orders) == 0) { ?>
                <div class="empty-content">您还没有购买任何课程哦~赶紧去<a href="/course/list" class="go-link">挑选课程&gt;&gt;</a></div>
                <?php } else { ?>
                <dl class="cc">
                    <dd class="htqhnow" order-status="all">>全部状态</dd>
                    <dd order-status="wait_pay">未付款</dd>
                    <dd order-status="ing_pay">付款中</dd>
                    <dd order-status="had_pay">已付款</dd>
                </dl>
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
                        } else if ($goods_item->type == 'course_package') {
                        $course = CoursePackage::find()
                        ->where(['id' => $goods_item->goods_id])
                        ->one();
                        $course_name = $course->name;
                        }

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
                        </div>
                        <?php } } ?>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        function qiehuan(qhan, qhshow, qhon) {
            $(qhan).click(function () {
                $(qhan).removeClass(qhon);
                $(this).addClass(qhon);
            });
        }

        qiehuan(".httxt1 dd", ".httxt1 ul", "htqhnow");
    });
</script>
</body>
</html>
