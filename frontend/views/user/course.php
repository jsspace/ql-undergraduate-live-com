<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;

$this->title = '我的班级';
?>
<div class="htcontent">
    <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">我的班级</a></h2>
    <div class="htbox2">
        <div class="httxt1 cc">
            <h3 class="ht_tt1">我的班级</h3>
            <dl class="cc">
                <dd class="htqhnow">正在学</dd>
                <dd class="htqh2">已结课</dd>
            </dl>
            <ul>
                <?php foreach ($clist as $key => $course) { ?>
                    <li>
                        <img src="/images/htpic2.jpg" width="298" height="108" />
                        <h4><?= $course->course_name ?></h4>
                        <h5><img src="/images/htpic3.jpg" width="70" height="70" /><p>班主任</p></h5>
                        <div class="tyny">
                            <p><img src="/images/nyicon1.png" />课堂学（13）</p>
                            <p><img src="/images/nyicon1a.png" />随堂练（13）</p>
                            <p><img src="/images/nyicon1b.png" />问老师（18）</p>
                            <p><img src="/images/nyicon1.png" />模拟考（1）</p>
                            <p class="httx"><img src="/images/hticon10.png" />同学20</p>
                        </div>
                    </li>
                <?php } ?>
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
            </ul>
        </div>
    </div>
</div>
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