<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\Course;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
AppAsset::addCss($this,'@web/css/main.css');

$this->title = '课程详情';
?>
<div class="indexgg indexgg">
    <dl>
        <dt><img src="/images/lbicon1.png" />最新公告：2017年行政管理专业各科真题及答案汇编</dt>
    </dl>
</div>
<div class="main cc" style="padding:35px 0;">
    <dl class="nytxt2">
        <dt>
        <video src="http://jq22com.qiniudn.com/jq22-sp.mp4" controls="controls" loop="loop" x-webkit-airplay="true" webkit-playsinline="true"></video>
        </dt>
        <dd>
            <h4>普通话语音与发声</h4>
            <p class="bjxq1">价格： <code>￥680.00</code>    原价： <del>￥1000.00</del></p>
            <p>1256974人正在学习</p>
            <p>主讲：苏红</p>
            <p class="bjxq2"><code class="xq2now">课堂学13次</code><code>随堂练13次</code><code>模拟考1次</code></p>
            <p class="bjxq3"><span><a href="#">购买课程</a></span><code class="colorfff"><a href="#"><img src="/images/nyicon2.png" />分享</a></code><code class="colorfff"><a href="#"><img src="/images/nyicon2a.png" />收藏</a></code></p>
        </dd>
    </dl>
    <div class="nytxt3 cc">
        <div class="nytxt3_l">
            <div class="nytxt3_lny1">
                <dl class="cc">
                    <dd><a href="#">课程介绍</a></dd>
                    <dd class="kcnow"><a href="#">课堂学</a></dd>
                    <dd><a href="#">随堂练</a></dd>
                    <dd><a href="#">问老师</a></dd>
                    <dd><a href="#">模拟考</a></dd>                    
                    <dt><a href="#">班主任</a></dt>
                </dl>
                <ul class="color2">
                    <li><code class="colorfff"><a href="#">免费试听</a></code><span>第一节</span>什么是普通话</li>
                    <li><span>第一节</span>什么是普通话</li>
                    <li><span>第一节</span>什么是普通话</li>
                    <li><span>第一节</span>什么是普通话</li>
                    <li><span>第一节</span>什么是普通话</li>
                    <li><span>第一节</span>什么是普通话</li>
                    <li><code class="colorfff"><a href="#">免费试听</a></code><span>第一节</span>什么是普通话</li>
                </ul>
            </div>
            <div class="page"><a href="#">&lt;</a><a href="#" class="pagenow">1</a><a href="#">2</a><a href="#">&gt;</a></div>
        </div>
        <div class="nytxt3_r">
            <dl class="nytxt3_rny1">
                <dt><img src="/images/nypic2.jpg" width="130" height="180" /></dt>
                <dd>
                    <h4>主讲老师</h4>
                    <p class="rny1name">苏红</p>
                    <p>中国传媒大学讲师</p>
                    <p>博士，签约导师</p>
                </dd>
            </dl>
            <div class="nytxt3_rny2 cc">
                <h3>辅导老师</h3>
                <ul>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
