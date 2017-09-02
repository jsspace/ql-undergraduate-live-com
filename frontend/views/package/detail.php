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
                <p class="package-name">前端框架介绍<i><img src="/img/qrcode-img.png"/></i></p>
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
    <div class="bottom-package">
        <div class="package-inner">
            <div class="left-section">
                <ul class="title-list">
                    <li class="active">介绍</li>
                    <li>课程</li>
                    <li>评价</li>
                    <li>话题</li>
                    <li>笔记</li>
                    <li>师资</li>
                </ul>
                <div class="con-list">
                    <div class="con-detail active">
                        课程介绍
                    </div>
                    <div class="con-detail">
                        <ul class="course-list">
                            <li>
                                <div class="show-section">
                                    <a href="" class="course-img"><img src="/img/no-video.jpg"/></a>
                                    <p class="course-title">
                                        <span class="title">前端框架结构</span>
                                        <span class="star">
                                            <i class="icon ion-ios-star"></i>   
                                            <i class="icon ion-ios-star-half"></i>  
                                            <i class="icon ion-ios-star-outline"></i>
                                        </span>
                                    </p>
                                    <p class="price">
                                        <span>原价：￥15元</span>
                                    </p>
                                </div>
                                <div class="hide-section">
                                    <div class="course-detail-list">
                                        <a href="" class="name">课时1：前端框架结构<i class="icon ion-ios-download-outline"></i></a>
                                        <span class="time">6:40<i class="icon ion-videocamera"></i></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="con-detail">
                        评价
                    </div>
                    <div class="con-detail">
                        话题
                    </div>
                    <div class="con-detail">
                        笔记
                    </div>
                    <div class="con-detail">
                        <ul class="teacher-section">
                            <li>
                                <div class="top">
                                    <p class="teacher-img"><img src="/img/teacher-people.png"/></p>
                                    <p class="teacher-name">张老师</p>
                                    <p class="teacher-tag">中国著名数码后期讲师 美国PSA摄影学会会</p>
                                </div>
                                <div class="teacher-info">委员会委员委员会委员委员会委员委员会委员委员会委员委员会委员</div>
                                <div class="teacher-info second-info">
                                    <a href="" class="btn">关注</a>
                                    <a href="" class="btn">私信</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="right-section">
                <div class="section">
                    <h3>班主任</h3>
                    <p class="txt">该套餐未设置班主任</p>
                </div>
                <div class="section">
                    <h3>新加学员</h3>
                    <ul class="user-img">
                        <li><img src="/img/teacher-people.png"/></li>
                        <li><img src="/img/teacher-people.png"/></li>
                        <li><img src="/img/teacher-people.png"/></li>
                        <li><img src="/img/teacher-people.png"/></li>
                        <li><img src="/img/teacher-people.png"/></li>
                        <li><img src="/img/teacher-people.png"/></li>
                    </ul>
                </div>
                <div class="section">
                    <h3>学员动态</h3>
                    <div class="news-list">
                        <a href="">某某某某某某某某某某某某</a>
                        <a href="">某某某某某某某某某某某某</a>
                        <a href="">某某某某某某某某某某某某</a>
                        <a href="">某某某某某某某某某某某某</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script>
    $(function() {
        $(".title-list li").each(function(index) {
            $(this).on("click", function() {
                $(this).addClass("active").siblings("li").removeClass("active");
                $(".con-list").find(".con-detail").eq(index).addClass("active").siblings(".con-detail").removeClass("active");
            });
        });
    });
</script>