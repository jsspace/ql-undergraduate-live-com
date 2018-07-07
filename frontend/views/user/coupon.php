<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;
use backend\models\Coupon;

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
            <li><a href="/user/class"><span><img src="/images/hticon3.png"/><cite><img
                    src="/images/hticon3a.png"/></cite></span>我的班级</a></li>
            <li><a href="/user/orders"><span><img src="/images/hticon4.png"/><cite><img
                    src="/images/hticon4a.png"/></cite></span>我的订单</a></li>
            <li><a href="/user/favorite"><span><img src="/images/hticon6.png"/><cite><img
                    src="/images/hticon6a.png"/></cite></span>我的收藏</a></li>
            <li class="htleftnow"><a href="/user/coupon"><span><img src="/images/hticon7.png"/><cite><img
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
        <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">我的奖励</a></h2>
        <div class="htbox2">
            <div class="httxt1 cc">
                <h3 class="ht_tt1">我的奖励</h3>

                <?php if (count($coupons) == 0) { ?>
                <div class="empty-content">
                    暂无可用优惠券
                </div>
                <?php } else { ?>
                <dl class="cc">
                    <dd class="htqhnow" coupon-status="all">全部</dd>
                    <dd coupon-status="0">未使用</dd>
                    <dd coupon-status="1">使用中</dd>
                    <dd coupon-status="2">已使用</dd>
                </dl>
                <div class="coupon-wrapper">
                    <ul class="coupon-title-line">
                        <li class="coupon-name">优惠券名称</li>
                        <li class="coupon-money">优惠券金额</li>
                        <li class="coupon-status">使用状态</li>
                        <li class="coupon-daterange">有效期</li>
                    </ul>
                    <ul class="coupon-content-line _coupon-list">
                        <?php foreach ($coupons as $key => $coupon) {
                        //$coupon->isuse 0:未使用 1 使用中 2 已使用
                        ?>
                        <li coupon-status="<?= $coupon->isuse ?>">
                            <p class="coupon-name"><?= $coupon->name ?></p>
                            <p class="coupon-money">￥<?= $coupon->fee ?></p>
                            <p class="coupon-status"><?= Coupon::item($coupon->isuse) ?></p>
                            <p class="coupon-daterange"><?= date('Y-m-d', strtotime($coupon->start_time))
                                ?>至<?= date('Y-m-d', strtotime($coupon->end_time)) ?></p>
                        </li>

                        <?php } ?>
                        <div class="empty-content" style="display: none;">暂无</div>
                    </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            var emptyEl = $('.empty-content');
            function qiehuan(qhan, qhon) {
                $(qhan).click(function () {
                    emptyEl.hide();
                    $(qhan).removeClass(qhon);
                    $(this).addClass(qhon);
                    var couponStatus = $(this).attr("coupon-status");
                    if (couponStatus === "all") {
                        $("._coupon-list li").show();
                    } else {
                        $("._coupon-list li").hide();
                        var filterList = $("._coupon-list li[coupon-status='" + couponStatus +"']");
                        if (filterList.length === 0) {
                            emptyEl.show();
                        } else {
                            filterList.show();
                        }
                    }
                });
            }

            qiehuan(".httxt1 dd", "htqhnow");
        });
        $(function() {
            $("._coupon-status .status-list li").each(function() {
                $(this).on("click", function() {

                });
            });
        });

    </script>
</body>
</html>
