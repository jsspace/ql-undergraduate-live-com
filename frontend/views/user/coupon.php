<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;
use backend\models\Coupon;

$this->title = '我的奖励';
?>

    <div class="htcontent">
        <h2 class="htwx cc"><a href="/">首页</a>&gt;<a href="#">我的奖励</a></h2>
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
    </script>
</body>
</html>
