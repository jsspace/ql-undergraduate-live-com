<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/index.css');
AppAsset::addCss($this,'@web/css/how-to-study.css');

$this->title = '如何上课';
?>
<div class="banner" style="background:url(/images/how-to-stydy-banner.png) center top no-repeat;height: 288px; overflow: hidden;">
    <dl>
        <dt>
            <p>这里不仅是课好……</p>
            <h4>选择都想学  升本有保障 </h4>
            <span class="colorfff"><a href="/course/list">查看更多</a></span>
        </dt>
    </dl>
</div>
<div class="main cc" style="padding-bottom:0;">
    <div class="indextt1">
        <h3>课堂学习步骤<p>随时向老师提问，课程结束后参加本课程随堂考试</p><em></em></h3>All want to learn three pairs of a gang
    </div>
    <ul class="study-step">
        <li>
            <img src="/images/study1.png" />
            <p>第一步：视频听课</p>
        </li>
        <li>
            <img src="/images/study2.png" />
            <p>第二步：做随堂练习，并通过手机提交</p>
        </li>
        <li>
            <img src="/images/study3.png" />
            <p>第三步：查看老师批阅及答案讲解</p>
        </li>
    </ul>
</div>

<div class="main cc" style="margin-top: 50px;">
    <div class="indextt1">
        <h3>电脑学习备用软件<p>你的浏览器必须是IE9.0以上版本，或360浏览器极速模式，推荐使用谷歌浏览器</p><em></em></h3>All want to learn three pairs of a gang
    </div>
    <ul class="study-soft">
        <li>
            <img src="/images/study-soft-icon1.png" alt="">
            <div>
                <p class="soft-name">TeamView远程协助软件</p>
                <p class="soft-info">当有技术故障的时候，打开此软件后，告诉我们的技术软件ID与密码，可快速远程协助修复故障。(软件关闭密码即无效，每次启动密码都不一样)</p>
                <a href="" class="download-link">Widnows系统下载</a>
                <a href="" class="download-link">Mac系统下载</a>
            </div>
            
        </li>
        <li>
            <img src="/images/study-soft-icon2.png" alt="">
            <div>
                <p class="soft-name">谷歌浏览器</p>
                <p class="soft-info">如果你的电脑无法正常学习“都想学”，我们推荐你使用谷歌浏览器，它是目前速度最快，上课最稳定的浏览器。</p>
                <a href="" class="download-link">Widnows系统下载</a>
                <a href="" class="download-link">Mac系统下载</a>
            </div>
        </li>
    </ul>
</div>
<div class="line"></div>
<div class="scan">
    <div>
        <p class="scan-title">手机学习通道</p>
        <p class="scan-info">关注公众号“都想学考本帮”，进入手机端网站学习</p>
    </div>
    <img src="/images/public-erweima.jpg" alt="">
</div>

