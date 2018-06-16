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
            <span class="colorfff"><a href="#">查看更多</a></span>
        </dt>
    </dl>
</div>
<div class="indexgg indexgg">
    <dl>
        <dt><img src="/images/lbicon1.png" />最新公告：2017年行政管理专业各科真题及答案汇编</dt>
    </dl>
</div>
<div class="main cc" style="padding-bottom:0;">
    <div class="indextt1">
        <h3>课程内容由命题老师设计<p>课程内容紧扣考试重点，讲解详略得当</p><em></em></h3>All want to learn three pairs of a gang
    </div>
    <ul class="indextxt1 cc">
        <li>
            <img src="/images/txt1_icon1.png" />
            <h4>三种班型</h4>
            <p>每门课程均开设强化、串讲、冲刺三个班型，将分别在不同时间段推出；</p>
        </li>
        <li>
            <img src="/images/txt1_icon2.png" />
            <h4>按知识点设计</h4>
            <p>课程内容紧扣考试重点，抛弃与考试无关内容</p>
        </li>
        <li>
            <img src="/images/txt1_icon3.png" />
            <h4>模拟考试</h4>
            <p>每种班型均有模拟考试，内容有往年命题教师设计</p>
        </li>
    </ul>
</div>
<div class="hfgg1" style="height:450px; background:url(/images/hfgg1.jpg) center top no-repeat;">
    <a href="#"></a>
</div>
<div class="main cc">
    <div class="indextt1">
        <h3>智能在线学习效率高  时间自由 价格低<p>课程内容紧扣考试重点，讲解详略得当</p><em></em></h3>All want to learn three pairs of a gang
    </div>
    <ul class="indextxt2 cc">
        <li><a href="#"><img src="/images/indexpic2.jpg" width="361" height="215" /><p>效率优势：课堂视频内容精简，线上20分钟的知识量大于面授一小时的知识量，学情报告记录薄弱环节，查缺补漏效率更高；</p></a></li>
        <li><a href="#"><img src="/images/indexpic2a.jpg" width="361" height="215" /><p>时间优势：学习时间不再受限，课表由自己设定；</p></a></li>
        <li><a href="#"><img src="/images/indexpic2b.jpg" width="361" height="215" /><p>价格优势：学费远低于面授价格；</p></a></li>
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
                    <div class="swiper-slide"><a href="#"><img src="/images/indexpic3b.jpg" /><p>答疑辅导老师：答疑老师全天候（早6:00—晚10:00）在线，针对疑问即时回复。</p></a></div>
                    <div class="swiper-slide"><a href="#"><img src="/images/indexpic3.jpg" /><p>专职班主任：班主任专门负责学员管理与服务，当你遇到一切与平台学习有关的困难，班主任都会帮你解决。</p></a></div>
                    <div class="swiper-slide"><a href="#"><img src="/images/indexpic3a.jpg" /><p>作业批改老师：老师来自高校教师及知名院校相关专业研究生，作业批阅及时。</p></a></div>
                </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</div>
<div class="main cc">
    <div class="indextt1a indextt1">
        <h3>课堂形式丰富多样<p>课堂由精讲视频、课堂练习、练习批改、讲解、答疑辅导五部分组成</p><em></em></h3>All want to learn three pairs of a gang
    </div>
    <ul class="indextxt4 cc">
        <li>
            <a href="#">
        <span>
        <img src="/images/txt4_icon1.png" width="52" height="52" />
        </span>
        <h4>精讲视频</h4>
        <p>专家线上授课，内容精致，语言讲练，线上1分钟胜过面授3分钟的知识量</p>
        </a>
        </li>
        <li class="txt4li4"></li>
        <li>
            <a href="#">
        <span>
        <img src="/images/txt4_icon2.png" width="52" height="52" />
        </span>
        <h4>课堂练习</h4>
        <p>巩固课堂知识，加强重点练习</p>
        </a>
        </li>
        <li class="txt4li4"></li>
        <li>
            <a href="#">
        <span>
        <img src="/images/txt4_icon3.png" width="52" height="52" />
        </span>
        <h4>专人批改</h4>
        <p>作业辅导老师全天恭候，即时批改作业，系统生成学情报告</p>
        </a>
        </li>
        <li class="txt4li4"></li>
        <li>
            <a href="#">
        <span>
        <img src="/images/txt4_icon4.png" width="52" height="52" />
        </span>
        <h4>答案讲解</h4>
        <p>与课堂练习配套的讲解</p>
        </a>
        </li>
        <li class="txt4li4"></li>
        <li>
            <a href="#">
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
                <img src="/images/indexpic5.jpg" width="36" height="36" />
                <h4>依依紫</h4>
                <p><span>当前版本</span><span>09-07</span><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>看完新闻时返回时总是前几页，而不是现在看的这页，很麻烦。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/indexpic5.jpg" width="36" height="36" />
                <h4>依依紫</h4>
                <p><span>当前版本</span><span>09-07</span><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>看完新闻时返回时总是前几页，而不是现在看的这页，很麻烦。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/indexpic5.jpg" width="36" height="36" />
                <h4>依依紫</h4>
                <p><span>当前版本</span><span>09-07</span><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>看完新闻时返回时总是前几页，而不是现在看的这页，很麻烦。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/indexpic5.jpg" width="36" height="36" />
                <h4>依依紫</h4>
                <p><span>当前版本</span><span>09-07</span><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>看完新闻时返回时总是前几页，而不是现在看的这页，很麻烦。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/indexpic5.jpg" width="36" height="36" />
                <h4>依依紫</h4>
                <p><span>当前版本</span><span>09-07</span><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>看完新闻时返回时总是前几页，而不是现在看的这页，很麻烦。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/indexpic5.jpg" width="36" height="36" />
                <h4>依依紫</h4>
                <p><span>当前版本</span><span>09-07</span><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>看完新闻时返回时总是前几页，而不是现在看的这页，很麻烦。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/indexpic5.jpg" width="36" height="36" />
                <h4>依依紫</h4>
                <p><span>当前版本</span><span>09-07</span><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>看完新闻时返回时总是前几页，而不是现在看的这页，很麻烦。</dd>
        </dl>
        <dl>
            <dt>
                <img src="/images/indexpic5.jpg" width="36" height="36" />
                <h4>依依紫</h4>
                <p><span>当前版本</span><span>09-07</span><em class="xingji2"></em><em></em><em></em><em></em><em></em></p>
            </dt>
            <dd>看完新闻时返回时总是前几页，而不是现在看的这页，很麻烦。</dd>
        </dl>
    </div>
    <div class="txt5more colorfff"><a href="#">更多</a></div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?php echo Url::to('@web/js/swiper.min.js');?>"></script>
<script src="<?php echo Url::to('@web/js/index.js');?>"></script>