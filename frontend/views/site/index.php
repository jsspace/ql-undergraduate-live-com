<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\CourseCategory;

AppAsset::addCss($this,'@web/css/index.css');
AppAsset::addCss($this,'@web/css/swiper.min.css');
AppAsset::addCss($this,'@web/css/certify.css');

$this->title = '首页';

$weekarray=array("日","一","二","三","四","五","六"); 

?>
<div class="banner" style="background:url(/images/ban1.jpg) center top no-repeat;">
    <dl>
        <dt>
            <p>这里不仅是课好……</p>
            <h4>选择都想学  升本有保障 </h4>
            <span class="colorfff"><a href="/course/list">查看更多</a></span>
        </dt>
    </dl>
</div>
<div class="indexgg">
    <img src="/images/lbicon1.png" />
    <dl>
        <?php foreach ($notices as $key => $notice) { ?>
            <dt>
                <a href="<?php if ($notice->url == '#') echo 'javascript:void(0)'; else echo $notice->url ?>">
                    <?= $notice->theme ?>
                </a>
            </dt>
        <?php } ?>
    </dl>
</div>
<div class="main cc" style="padding-bottom:0;">
    <div class="indextt1">
        <h3>课程内容由命题老师设计<p>课程内容紧扣考试重点，讲解详略得当</p><em></em></h3>All want to learn three pairs of a gang
    </div>
    <ul class="indextxt1 cc">
        <li>
            <img src="/images/txt1_icon1.png" />
            <h4>知识精讲</h4>
            <p>名师名校因材施教，言简意赅，内容紧扣大纲，高度浓缩精华；</p>
        </li>
        <li>
            <img src="/images/txt1_icon2.png" />
            <h4>同步训练</h4>
            <p>资深专家教研，深入研究真题，把握考试重点，训练内容直击考点；</p>
        </li>
        <li>
            <img src="/images/txt1_icon3.png" />
            <h4>通关测试</h4>
            <p>总结考试规律，预测命题趋势，真人批阅，记录错题，掌握学情；</p>
        </li>
    </ul>
</div>
<div class="hfgg1" style="height:450px; background:url(/images/hfgg1.jpg) center top no-repeat;">
    <a href="javascript:void(0)"></a>
</div>
<div class="main cc">
    <div class="indextt1">
        <h3>智能在线学习效率高  时间自由 价格低<p>课程内容紧扣考试重点，讲解详略得当</p><em></em></h3>All want to learn three pairs of a gang
    </div>
    <ul class="indextxt2 cc">
        <li><a href="javascript:void(0)"><img src="/images/indexpic2.jpg" width="361" height="215" /><p>效率优势：课堂视频内容精简，线上20分钟的知识量大于面授一小时的知识量，学情报告记录薄弱环节，查缺补漏效率更高；</p></a></li>
        <li><a href="javascript:void(0)"><img src="/images/indexpic2a.jpg" width="361" height="215" /><p>时间优势：学习时间不再受限，课表由自己设定；</p></a></li>
        <li><a href="javascript:void(0)"><img src="/images/indexpic2b.jpg" width="361" height="215" /><p>价格优势：学费远低于面授价格；</p></a></li>
    </ul>
</div>
<div class="indextxt3 cc">
    <div class="main cc" style="padding-bottom:0;">
        <div class="indextt1a indextt1">
            <h3>三对一海底捞式服务<p>网络学习不再孤独，时刻有人陪伴；</p><em></em></h3>All want to learn three pairs of a gang
        </div>
        <div id="certify">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="javascript:void(0)"><img src="/images/indexpic3b.jpg" /><p>答疑辅导老师：答疑老师全天候（早6:00—晚10:00）在线，针对疑问即时回复。</p></a></div>
                    <div class="swiper-slide"><a href="javascript:void(0)"><img src="/images/indexpic3.jpg" /><p>专职班主任：班主任专门负责学员管理与服务，当你遇到一切与平台学习有关的困难，班主任都会帮你解决。</p></a></div>
                    <div class="swiper-slide"><a href="javascript:void(0)"><img src="/images/indexpic3a.jpg" /><p>阅卷老师：老师来自高校教师及知名院校相关专业研究生，试卷批阅准确即时。</p></a></div>
                </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</div>
<div class="main cc">
    <div class="indextt1a indextt1">
        <h3>课堂形式丰富多样<p>课堂由精讲视频、课堂练习、答卷批阅、讲解、答疑辅导五部分组成</p><em></em></h3>All want to learn three pairs of a gang
    </div>
    <ul class="indextxt4 cc">
        <li>
            <a href="javascript:void(0)">
        <span>
        <img src="/images/txt4_icon1.png" width="52" height="52" />
        </span>
        <h4>精讲视频</h4>
        <p>专家线上授课，内容精致，语言讲练，线上1分钟胜过面授3分钟的知识量</p>
        </a>
        </li>
        <li class="txt4li4"></li>
        <li>
            <a href="javascript:void(0)">
        <span>
        <img src="/images/txt4_icon2.png" width="52" height="52" />
        </span>
        <h4>课堂练习</h4>
        <p>巩固课堂知识，加强重点练习</p>
        </a>
        </li>
        <li class="txt4li4"></li>
        <li>
            <a href="javascript:void(0)">
        <span>
        <img src="/images/txt4_icon3.png" width="52" height="52" />
        </span>
        <h4>专人批改</h4>
        <p>辅导老师全天恭候，即时批改答卷，系统生成学情报告</p>
        </a>
        </li>
        <li class="txt4li4"></li>
        <li>
            <a href="javascript:void(0)">
        <span>
        <img src="/images/txt4_icon4.png" width="52" height="52" />
        </span>
        <h4>答案讲解</h4>
        <p>与课堂练习配套的讲解</p>
        </a>
        </li>
        <li class="txt4li4"></li>
        <li>
            <a href="javascript:void(0)">
        <span>
        <img src="/images/txt4_icon5.png" width="52" height="52" />
        </span>
        <h4>VIP答疑辅导</h4>
        <p>辅导老师全天恭候，即时答疑</p>
        </a>
        </li>
    </ul>
    <div class="indextt1a indextt1">
        <h3>同学评说<p>课堂由精讲视频、课堂练习、练习批改、讲解、答疑辅导五部分组成</p><em></em></h3>All want to learn three pairs of a gang
    </div>
    <div class="indextxt5 cc">
        <dl>
            <dt>
                <img src="/images/student-pic-1.png" width="36" height="36" />
                <h4>商职院李飞</h4>
                <p><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>讲课内容紧凑、丰富，并附有大量例题和练习题，十分有利于同学们在较短时间内掌握课程内容。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/student-pic-2.png" width="36" height="36" />
                <h4>齐鲁工大刘佳</h4>
                <p><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>单元测验太好了，老师批改及时，通过单元测验让我找到了薄弱环节。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/student-pic-3.png" width="36" height="36" />
                <h4>青职院张果果</h4>
                <p><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>真没想到老师能这么及时的回复我，以后学习过程中遇到的难题再也不用愁了，直接通过都想学平台问老师呗。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/student-pic-4.png" width="36" height="36" />
                <h4>烟职院王龙</h4>
                <p><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>没想到在线学习比面授班感觉还好，提问能速回，还有专人给改答卷，还有课堂练习，考虑的太周到了，以后上辅导班再也不用东北西跑了。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/student-pic-5.png" width="36" height="36" />
                <h4>齐鲁师院晴雯</h4>
                <p><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>本来还以为是传统的网络课件呢，学过以后才知道竟然还有专职班主任，一门课程还配备这么多辅导老师，提问简直是秒回，视频讲解真是精炼呀，基本没有废话，效率太高了，真是神了。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/student-pic-6.png" width="36" height="36" />
                <h4>经干院李立功</h4>
                <p><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>正愁面授班的培训费呢，“都想学”就来了，你的价格好亲民呀，像我这样农民家庭出身的孩子也能学得起，感谢“都想学”！</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/student-pic-8.png" width="36" height="36" />
                <h4>农干院高燕</h4>
                <p><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>老师授课的方式非常适合我们，他根据本课程知识结构的特点，重点突出，层次分明...</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/student-pic-7.png" width="36" height="36" />
                <h4>山传于欣欣</h4>
                <p><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>老师授课有条理，有重点，课堂内容充实，简单明了，使学生能够轻轻松松掌握知识。</dd>
        </dl>
    </div>
    <!-- <div class="txt5more colorfff"><a href="javascript:void(0)">更多</a></div> -->
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?php echo Url::to('@web/js/swiper.min.js');?>"></script>
<script src="<?php echo Url::to('@web/js/index.js');?>"></script>