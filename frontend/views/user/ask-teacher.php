<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;
AppAsset::addCss($this,'@web/css/ask-teacher.css');

$this->title = '直播答疑';

?>

<div class="htcontent">
        <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">直播答疑</a></h2>
        <div class="htbox2">
            <div class="httxt1 cc">
                <h3 class="ht_tt1">直播答疑</h3>
                <div class="course-list">
                    <div class="chinese">
                        <div class="bg"></div>
                        <span>语文</span>
                        <img src="/images/htwxpic1.jpg">
                    </div>
                    <div class="mathematics">
                        <div class="bg"></div>
                        <span>数学</span>
                        <img src="/images/htwxpic1.jpg">
                    </div>
                    <div class="english">
                        <div class="bg"></div>
                        <span>英语</span>
                        <img src="/images/htwxpic1.jpg">
                    </div>
                    <div class="computer">
                        <div class="bg"></div>
                        <span>计算机</span>
                        <img src="/images/htwxpic1.jpg">
                    </div>
                </div>
            </div>
            <!-- <div class="httxt2">
                <ul class="cc">
                    <li>我的</li>
                    <li class="htktnow">全部</li>
                </ul>
                <div class="httxt2_show">
                    <ul>
                        <li>
                            <img src="/images/htpic1.png" alt="">
                            <div>
                                <p></p>
                            </div>
                        </li>
                    </ul>
            
                </div>
            </div> -->
        </div>
    </div>

</body>
</html>
