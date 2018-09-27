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
        <h2 class="htwx cc"><a href="/">首页</a>&gt;<a href="#">邀请好友</a></h2>
        <div class="htbox2">
            <div class="httxt1 cc">
                <h3 class="ht_tt1">邀请好友</h3>
                <div class="share-wrap">
                    <p class="share-title">邀请好友，双方各得50元优惠券</p>
                    <img src="/images/wxpic1.jpg">
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        .share-wrap img {
            margin: 0 auto;
        }
        .share-title {
            font-size: 18px;
            color: #fc9032;
            text-align: center;
            border-top: 1px solid #dfdfdf;
            padding: 30px 0;
        }
    </style>
    <script src="/js/jquery.js" type="text/javascript"></script>
</body>
</html>
