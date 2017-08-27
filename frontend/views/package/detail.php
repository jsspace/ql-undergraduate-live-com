<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/package.css');

$this->title = 'My Yii Application';
?>
<div class="package-detail-section">
    <div class="top-package">
        <div class="package-inner">
            <div class="left-package">
                <div class="img-package"><img src="/img/no-video.jpg"/></div>
                <div class="package-mask">
                    <p class="title">前端框架结构介绍</p>
                    <div class="package-list">
                        <p class="package-icon"><img src="/img/package-icon.png"/></p>
                        <p class="pack-t"><span class="num">4</span>门课程</p>
                        <p class="pack-con">1.vue.js介绍</p>
                        <p class="pack-con">2.vue.js介绍</p>
                        <p class="pack-con">3.vue.js介绍</p>
                        <p class="pack-con">4.vue.js介绍</p>
                    </div>
                </div>
            </div>
            <div class="right-package">
                <p class="package-name">前端框架介绍<i><img src="/img/qrcode.png"/></i></p>
                <p class="package-icon-list">
                    <span><i class="icon ion-clock"></i> 30分钟</span>
                    <span><i class="icon ion-android-person"></i> 121人</span>
                    <span><i class="icon ion-document-text"></i> 2017.4.7</span>
                </p>
                <p class="package-detail">低饱和色调是介于黑白色调和彩色色调之间的一种过渡色调，通过减少画面的色彩饱和度让我们避免了强烈的色彩信息对我们对情绪的干扰，给画面带来一种比较质朴、安静、简约的画面感，同时也保留了少量的色彩信息避免让整个画面过于凝重，多了一些色彩的跳跃性，所以我们在处理人文片的时候，把它处理成低...</p>
                <p class="package-price">
                    <span class="price-tag">现价</span>
                    <span class="price-highlight">65元</span>
                    <span class="price-tag">原价</span> 105元
                </p>
                <a href="" class="package-btn btn-red">我要报名</a>
                <a href="" class="package-btn btn-green">开通会员</a>
                <p class="tips-detail">加入会员免费学（已有190名会员加入）</p>
            </div>
        </div>
    </div>
</div>