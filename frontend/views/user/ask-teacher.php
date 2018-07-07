<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;
AppAsset::addCss($this,'@web/css/ask-teacher.css');
?>

<div class="htcontent">
        <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">问老师</a></h2>
        <div class="htbox2">
            <div class="httxt1 cc">
                <h3 class="ht_tt1">问老师</h3>
                <div class="course-list">
                    <div>语文</div>
                    <div>数学</div>
                    <div>英语</div>
                    <div>计算机</div>
                </div>
            </div>
            <div class="httxt2">
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
            </div>
        </div>
    </div>

</body>
</html>
