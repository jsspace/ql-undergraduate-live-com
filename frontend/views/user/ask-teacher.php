<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;
AppAsset::addCss($this,'@web/css/ask-teacher.css');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>个人中心</title>
    <meta name="description" content="个人中心" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="/css/htmain.css" type="text/css" media="screen" />
</head>
<body>
<div id="httop" class="colorfff cc">
    <h1><a href="/"><img src="/images/htlogo.png" /></a></h1>
    <ul>
        <li><a href="#"><img src="/images/hticon1.png" />我的课表</a></li>
        <li><a href="#"><img src="/images/hticon1a.png" />热门班级</a></li>
        <li><a href="/course/open"><img src="/images/hticon1b.png" />公开课</a></li>
        <li><a href="#"><img src="/images/hticon1c.png" />个人资料</a></li>
        <li><a href="/about/how-to-study"><img src="/images/hticon1d.png" />如何上课</a></li>
        <li><a href="#"><img src="/images/hticon1e.png" />问老师</a></li>
    </ul>
    <dl>
        <dd class="hthome"><img src="/images/htpic1.png" width="60" height="60" /><span><p><a href="#"><?= Yii::$app->user->identity->username || '尊敬的用户' ?></a></p><p><a href="/">官网首页</a></p></span></dd>
        <dd class="htxx"><a href="/user/message"><img src="/images/hticon2.png" />消息<code>8</code></a></dd>
        <dd class="htexit"><a href="<?= Url::to(['site/logout']) ?>"><img src="/images/hticon2a.png" />退出</a></dd>
    </dl>
</div>
<div id="htbox">
    <div class="htsidebar">
        <h3 class="colorfff">个人中心</h3>
        <ul>
            <li><a href="/user/class"><span><img src="/images/hticon3.png" /><cite><img src="/images/hticon3a.png" /></cite></span>我的班级</a></li>
            <li class="htleftnow"><a href="/user/orders"><span><img src="/images/hticon4.png" /><cite><img src="/images/hticon4a.png" /></cite></span>我的订单</a></li>
            <li><a href="/user/favorite"><span><img src="/images/hticon6.png" /><cite><img src="/images/hticon6a.png" /></cite></span>我的收藏</a></li>
            <li><a href="/user/coupon"><span><img src="/images/hticon7.png" /><cite><img src="/images/hticon7a.png" /></cite></span>我的奖励</a></li>
            <li><a href="#"><span><img src="/images/hticon9.png" /><cite><img src="/images/hticon9a.png" /></cite></span>邀请好友</a></li>
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
                <h4><img src="/images/htwxicon1.png" />微信客服</h4>
                <p><img src="/images/kefu-erweima.jpg" /></p>
            </dd>
        </dl>
    </div>
    <div class="htcontent">
        <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">问老师</a></h2>
        <div class="htbox2">
            <div class="httxt1 cc">
                <h3 class="ht_tt1">问老师</h3>
                <ul class="course-list">
                    <li>语文</li>
                    <li>高数</li>
                    <li>英语</li>
                    <li>计算机</li>
                </ul>
                <ul style="display:none">
                    <li>
                        <img src="/images/htpic2.jpg" width="298" height="108" />
                        <h4>2全能培训班</h4>
                        <h5><img src="/images/htpic3.jpg" width="70" height="70" /><p>班主任</p></h5>
                        <div class="tyny">
                            <p><img src="/images/nyicon1.png" />课堂学（13）</p>
                            <p><img src="/images/nyicon1a.png" />随堂练（13）</p>
                            <p><img src="/images/nyicon1b.png" />问老师（18）</p>
                            <p><img src="/images/nyicon1.png" />模拟考（1）</p>
                            <p class="httx"><img src="/images/hticon10.png" />同学20</p>
                        </div>
                    </li>
                    <li>
                        <img src="/images/htpic2.jpg" width="298" height="108" />
                        <h4>全能培训班</h4>
                        <h5><img src="/images/htpic3.jpg" width="70" height="70" /><p>班主任</p></h5>
                        <div class="tyny">
                            <p><img src="/images/nyicon1.png" />课堂学（13）</p>
                            <p><img src="/images/nyicon1a.png" />随堂练（13）</p>
                            <p><img src="/images/nyicon1b.png" />问老师（18）</p>
                            <p><img src="/images/nyicon1.png" />模拟考（1）</p>
                            <p class="httx"><img src="/images/hticon10.png" />同学20</p>
                        </div>
                    </li>
                    <li>
                        <img src="/images/htpic2.jpg" width="298" height="108" />
                        <h4>全能培训班</h4>
                        <h5><img src="/images/htpic3.jpg" width="70" height="70" /><p>班主任</p></h5>
                        <div class="tyny">
                            <p><img src="/images/nyicon1.png" />课堂学（13）</p>
                            <p><img src="/images/nyicon1a.png" />随堂练（13）</p>
                            <p><img src="/images/nyicon1b.png" />问老师（18）</p>
                            <p><img src="/images/nyicon1.png" />模拟考（1）</p>
                            <p class="httx"><img src="/images/hticon10.png" />同学20</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="httxt2">
                <ul class="cc">
                    <li>课堂学</li>
                    <li class="htktnow">随堂练</li>
                    <li>模拟考</li>
                    <li>问老师</li>
                    <li>学情报告</li>
                </ul>
                <div class="httxt2_show">
                    <div class="httxt2_an colorfff">
                        <code><a href="#">上传答题</a></code><code><a href="#">查看批改</a></code><code><a href="#">查看讲解</a></code></code>
                    </div>
                    <h4>全能培训班共13次随堂练习，已完成3次!</h4>
                    <h5>随堂练：<span>(做练习时不用抄题，直接在答题纸上写答案)</span></h5>
                    <dl class="ktshow cc">
                        <dt>课时03 指南针的奥秘</dt>
                        <dd><img src="/images/htpic4.jpg" /></dd>
                    </dl>
                    <dl class="cc">
                        <dt>课时03 指南针的奥秘</dt>
                        <dd><img src="/images/htpic4.jpg" /></dd>
                    </dl>
                    <dl class="cc">
                        <dt>课时03 指南针的奥秘</dt>
                        <dd><img src="/images/htpic4.jpg" /></dd>
                    </dl>
                    <dl class="cc">
                        <dt>课时03 指南针的奥秘</dt>
                        <dd><img src="/images/htpic4.jpg" /></dd>
                    </dl>
                    <dl class="cc">
                        <dt>课时03 指南针的奥秘</dt>
                        <dd><img src="/images/htpic4.jpg" /></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        function qiehuan(qhan,qhshow,qhon){
            $(qhan).click(function(){
                $(qhan).removeClass(qhon);
                $(this).addClass(qhon);
                var i = $(this).index(qhan);
                $(qhshow).eq(i).show().siblings(qhshow).hide();
            });
        }
        qiehuan(".httxt1 dd",".httxt1 ul","htqhnow");

        $(".httxt2_show dl dt").click(function(){
            $(".httxt2_show dl").removeClass("ktshow");
            $(this).parent().addClass("ktshow");
        })

    });
</script>
</body>
</html>
