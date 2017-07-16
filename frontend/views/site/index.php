<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="live-course">
        <div class="live-course-container">
            <div class="left-video">
                <img src="/img/no-video.jpg" class="no-video"/>
                <a href="" class="enter-video-btn">进入教室</a>
            </div>
            <div class="right-list">
                <div class="data-title">
                    <span class="time">7月16号&nbsp;&nbsp;星期天</span>
                </div>
                <ul class="video-title-list">
                    <li class="active">
                        <i class="icon-circle"></i>
                        <a href="">
                            <span class="top">22:00-23:00</span>
                            <span class="bottom">前端设计精选课程</span>
                        </a>
                    </li>
                    <li>
                        <i class="icon-circle"></i>
                        <a href="">
                            <span class="top">22:00-23:00</span>
                            <span class="bottom">前端设计精选课程</span>
                        </a>
                    </li>
                    <li>
                        <i class="icon-circle"></i>
                        <a href="">
                            <span class="top">22:00-23:00</span>
                            <span class="bottom">前端设计精选课程</span>
                        </a>
                    </li>
                    <li>
                        <i class="icon-circle"></i>
                        <a href="">
                            <span class="top">22:00-23:00</span>
                            <span class="bottom">前端设计精选课程</span>
                        </a>
                    </li>
                    <li>
                        <i class="icon-circle"></i>
                        <a href="">
                            <span class="top">22:00-23:00</span>
                            <span class="bottom">前端设计精选课程</span>
                        </a>
                    </li>
                    <li>
                        <i class="icon-circle"></i>
                        <a href="">
                            <span class="top">22:00-23:00</span>
                            <span class="bottom">前端设计精选课程</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="hot-section">
        <div class="container-course">
            <div class="course-hd">
                <h3 class="title">热门分类</h3>
                <div class="side">
                    <a href="/course/default?type=L" target="_blank" class="link more">更多&gt;&gt;</a>
                </div>
            </div>
            <ul class="list">
                <li class="item-1">
                    <a href="/course/default/category?depth=2&amp;cid=7&amp;type=L" target="_blank">
                        <i class="icon"></i>
                        <h3>平面设计</h3>
                        <div class="into"><span class="btn-into">进入科目</span></div>
                    </a>
                </li>
                <li class="item-2">
                    <a href="/course/default/category?depth=2&amp;cid=106&amp;type=L" target="_blank">
                        <i class="icon"></i>
                        <h3>UI设计</h3>
                        <div class="into"><span class="btn-into">进入科目</span></div>
                    </a>
                </li>
                <li class="item-3">
                    <a href="/course/default/category?depth=2&amp;cid=17&amp;type=L" target="_blank">
                        <i class="icon"></i>
                        <h3>室内设计</h3>
                        <div class="into"><span class="btn-into">进入科目</span></div>
                    </a>
                </li>
                <li class="item-4">
                    <a href="/course/default/category?depth=2&amp;cid=14&amp;type=L" target="_blank">
                        <i class="icon"></i>
                        <h3>建筑设计</h3>
                        <div class="into"><span class="btn-into">进入科目</span></div>
                    </a>
                </li>
                <li class="item-5">
                    <a href="/course/default/category?depth=2&amp;cid=13&amp;type=L" target="_blank">
                        <i class="icon"></i>
                        <h3>游戏动画</h3>
                        <div class="into"><span class="btn-into">进入科目</span></div>
                    </a>
                </li>
                        <li class="item-6">
                    <a href="/course/default/category?depth=2&amp;cid=8&amp;type=L" target="_blank">
                        <i class="icon"></i>
                        <h3>影视后期</h3>
                        <div class="into"><span class="btn-into">进入科目</span></div>
                    </a>
                </li>
                <li class="item-7">
                    <a href="/course/default/category?depth=2&amp;cid=9&amp;type=L" target="_blank">
                        <i class="icon"></i>
                        <h3>机械设计</h3>
                        <div class="into"><span class="btn-into">进入科目</span></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container-course course-section">
        <h3 class="course-title">课程套餐</h3>
        <fieldset>
            <legend>
                <img src="/img/arrow-icon.jpg"/>
            </legend>
        </fieldset>
        <ul class="course-tab">
            <li class="active">热门推荐</li>
            <li>最新课程</li>
            <li>课程排行</li>
        </ul>
        <div class="course-content">
            <ul class="list active">
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
            </ul>
            <ul class="list">
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称b</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
            </ul>
            <ul class="list">
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称c</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                </li>
            </ul>
        </div>
        <a href="" class="view-more">查看更多</a>
    </div>
    <div class="container-course course-online">
        <h3 class="course-title">在线课程</h3>
        <fieldset>
            <legend>
                <img src="/img/arrow-icon.jpg"/>
            </legend>
        </fieldset>
        <ul class="course-tab">
            <li class="active">热门推荐</li>
            <li>最新课程</li>
            <li>课程排行</li>
        </ul>
        <div class="course-content">
            <ul class="list active">
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
            </ul>
            <ul class="list">
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称b</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
            </ul>
            <ul class="list">
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称c</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
                <li>
                    <div class="course-img">
                        <img class="course-pic" src="/img/course-list-img.jpg"/>
                    </div>
                    <p class="content-title">课程名称课程名称课程名称课程名称</p>
                    <div class="course-statistic">
                        <i class="icon ion-android-person"></i>
                        <span class="people">11101人在学</span>
                        <i class="icon ion-heart"></i>
                        <span class="people">2345人</span>
                    </div>
                    <div class="teacher-section">
                        <img src="/img/teacher-icon.jpg"/>
                        <span class="teacher-name">张老师</span>
                    </div>
                </li>
            </ul>
        </div>
        <a href="" class="view-more">查看更多</a>
    </div>
    <div class="ads-section">
        <div class="ads-bar">
            <div class="container-course">
                <div class="md-bar-tit">
                    <div class="t1">截止目前</div><div class="t2">注册学员数量</div>
                </div>
                <div class="bar-box">
                    <div class="bar-number">143</div>
                    <div class="bar-text">报名学员</div>
                    <div class="bar-postion">位</div>
                </div>
                <div class="bar-box">
                    <div class="bar-number">106</div>
                    <div class="bar-text">合作机构</div>
                    <div class="bar-postion">家</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-course teacher-section">
        <h3 class="course-title">讲师团队</h3>
        <fieldset>
            <legend>
                <img src="/img/arrow-icon.jpg"/>
            </legend>
        </fieldset>
        <ul class="teach-list">
            <li>
                <img class="people-img" src="/img/teacher-people.png"/>
                <p class="intro">
                    <span class="name">韩大牛</span>
                    <span class="work">产品经理</span>
                </p>
                <p class="intro">
                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                    <span class="te-text">百度</span>
                </p>
                <p class="intro">
                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                    <span class="te-text">产品经理</span>
                </p>
            </li>
            <li>
                <img class="people-img" src="/img/teacher-people.png"/>
                <p class="intro">
                    <span class="name">韩大牛</span>
                    <span class="work">产品经理</span>
                </p>
                <p class="intro">
                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                    <span class="te-text">百度</span>
                </p>
                <p class="intro">
                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                    <span class="te-text">产品经理</span>
                </p>
            </li>
            <li>
                <img class="people-img" src="/img/teacher-people.png"/>
                <p class="intro">
                    <span class="name">韩大牛</span>
                    <span class="work">产品经理</span>
                </p>
                <p class="intro">
                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                    <span class="te-text">百度</span>
                </p>
                <p class="intro">
                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                    <span class="te-text">产品经理</span>
                </p>
            </li>
        </ul>
        <a href="" class="view-more">查看更多</a>
    </div>
    <div class="container-course course-data">
        <h3 class="course-title">考本资料</h3>
        <fieldset>
            <legend>
                <img src="/img/arrow-icon.jpg"/>
            </legend>
        </fieldset>
        <ul class="course-tab">
            <li class="active">类别一</li>
            <li>类别二</li>
            <li>类别三</li>
        </ul>
        <div class="course-content">
            <ul class="list active">
                <li>
                    <img class="course-data-img" src="/img/course-data-img.jpg"/>
                    <div class="right-con">
                        <p class="data-title">
                            <span class="data-label">职场必读</span>
                            <span>咨询课程咨询课程咨询课程咨询课程</span>
                        </p>
                        <p class="data-intro">做数据分析是同事我们㤇了解还有什么东西还来老外链外链了大家老师来了历史记录就辣椒酱蓝色框的看来离开时</p>
                        <p class="data-icon">
                            <img class="teach-img" src="/img/teacher-icon.jpg"/>
                            <span class="teach-name">张老师</span>
                            <i class="icon ion-android-person"></i>
                            <span class="people">11101人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people">2345人</span>
                        </p>
                    </div>
                </li>
                <li>
                    <img class="course-data-img" src="/img/course-data-img.jpg"/>
                    <div class="right-con">
                        <p class="data-title">
                            <span class="data-label">职场必读</span>
                            <span>咨询课程咨询课程咨询课程咨询课程</span>
                        </p>
                        <p class="data-intro">做数据分析是同事我们㤇了解还有什么东西还来老外链外链了大家老师来了历史记录就辣椒酱蓝色框的看来离开时</p>
                        <p class="data-icon">
                            <img class="teach-img" src="/img/teacher-icon.jpg"/>
                            <span class="teach-name">张老师</span>
                            <i class="icon ion-android-person"></i>
                            <span class="people">11101人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people">2345人</span>
                        </p>
                    </div>
                </li>
                <li>
                    <img class="course-data-img" src="/img/course-data-img.jpg"/>
                    <div class="right-con">
                        <p class="data-title">
                            <span class="data-label">职场必读</span>
                            <span>咨询课程咨询课程咨询课程咨询课程</span>
                        </p>
                        <p class="data-intro">做数据分析是同事我们㤇了解还有什么东西还来老外链外链了大家老师来了历史记录就辣椒酱蓝色框的看来离开时</p>
                        <p class="data-icon">
                            <img class="teach-img" src="/img/teacher-icon.jpg"/>
                            <span class="teach-name">张老师</span>
                            <i class="icon ion-android-person"></i>
                            <span class="people">11101人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people">2345人</span>
                        </p>
                    </div>
                </li>
                <li>
                    <img class="course-data-img" src="/img/course-data-img.jpg"/>
                    <div class="right-con">
                        <p class="data-title">
                            <span class="data-label">职场必读</span>
                            <span>咨询课程咨询课程咨询课程咨询课程</span>
                        </p>
                        <p class="data-intro">做数据分析是同事我们㤇了解还有什么东西还来老外链外链了大家老师来了历史记录就辣椒酱蓝色框的看来离开时</p>
                        <p class="data-icon">
                            <img class="teach-img" src="/img/teacher-icon.jpg"/>
                            <span class="teach-name">张老师</span>
                            <i class="icon ion-android-person"></i>
                            <span class="people">11101人在学</span>
                            <i class="icon ion-heart"></i>
                            <span class="people">2345人</span>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="course-referral">
            <h4 class="referral-title">课程推荐</h4>
            <div class="referral-content">
                <div class="top-section">
                    <img src="/img/referral-top.jpg"/>
                </div>
                <ul class="referral-list">
                    <li>
                        <span class="announce-title"><i></i>公告标题公告标题公告标题</span>
                        <span class="announce-time">2017-10-20</span>
                    </li>
                    <li>
                        <span class="announce-title"><i></i>公告标题公告标题公告标题</span>
                        <span class="announce-time">2017-10-20</span>
                    </li>
                    <li>
                        <span class="announce-title"><i></i>公告标题公告标题公告标题</span>
                        <span class="announce-time">2017-10-20</span>
                    </li>
                    <li>
                        <span class="announce-title"><i></i>公告标题公告标题公告标题</span>
                        <span class="announce-time">2017-10-20</span>
                    </li>
                    <li>
                        <span class="announce-title"><i></i>公告标题公告标题公告标题</span>
                        <span class="announce-time">2017-10-20</span>
                    </li>
                    <li>
                        <span class="announce-title"><i></i>公告标题公告标题公告标题</span>
                        <span class="announce-time">2017-10-20</span>
                    </li>
                    <a href="" class="more-link">更多&gt;&gt;</a>
                </ul>
            </div>
        </div>
    </div>
    <div class="cooperation-section">
        <div class="container-course">
            <h3 class="course-title">合作伙伴</h3>
            <fieldset>
                <legend>
                    <img src="/img/arrow-icon.jpg"/>
                </legend>
            </fieldset>
            <ul class="cooperation-list">
                <li class="cctv">
                    <img src="/img/cooperation-cctv.jpg"/>
                </li>
                <li class="kindon">
                    <img src="/img/cooperation-kindon.jpg"/>
                </li>
                <li class="anming">
                    <img src="/img/cooperation-anming.jpg"/>
                </li>
                <li class="xingye">
                    <img src="/img/cooperation-xingye.jpg"/>
                </li>
                <li class="juice">
                    <img src="/img/cooperation-juice.jpg"/>
                </li>
                <li class="ali">
                    <img src="/img/cooperation-ali.jpg"/>
                </li>
                <li class="china">
                    <img src="/img/cooperation-china.jpg"/>
                </li>
                <li class="construction">
                    <img src="/img/cooperation-construction.jpg"/>
                </li>
                <li class="jd">
                    <img src="/img/cooperation-jd.jpg"/>
                </li>
                <li class="vivo">
                    <img src="/img/cooperation-vivo.jpg"/>
                </li>
            </ul>
            <ul class="course-tab">
                <li class="active">用户评说</li>
                <li>友情链接</li>
            </ul>
            <div class="course-content">
                <ul class="list user-comment active">
                    <li>
                        <img src="/img/user-icon.jpg" class="user-img"/>
                        <div class="right-txt">
                            <span class="user-name">用户001</span>
                            <p class="user-txt">这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错</p>
                        </div>
                    </li>
                    <li>
                        <img src="/img/user-icon.jpg" class="user-img"/>
                        <div class="right-txt">
                            <span class="user-name">用户001</span>
                            <p class="user-txt">这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错</p>
                        </div>
                    </li>
                    <li>
                        <img src="/img/user-icon.jpg" class="user-img"/>
                        <div class="right-txt">
                            <span class="user-name">用户001</span>
                            <p class="user-txt">这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错</p>
                        </div>
                    </li>
                    <li>
                        <img src="/img/user-icon.jpg" class="user-img"/>
                        <div class="right-txt">
                            <span class="user-name">用户001</span>
                            <p class="user-txt">这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错</p>
                        </div>
                    </li>
                    <li>
                        <img src="/img/user-icon.jpg" class="user-img"/>
                        <div class="right-txt">
                            <span class="user-name">用户001</span>
                            <p class="user-txt">这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错</p>
                        </div>
                    </li>
                    <li>
                        <img src="/img/user-icon.jpg" class="user-img"/>
                        <div class="right-txt">
                            <span class="user-name">用户001</span>
                            <p class="user-txt">这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错这个课程不错</p>
                        </div>
                    </li>
                </ul>
                <ul class="list link-section">
                    <li><a href="">中国人民大学</a></li>
                    <li><a href="">中国航空航天大学</a></li>
                    <li><a href="">北京理工大学</a></li>
                    <li><a href="">中央名族大学</a></li>
                    <li><a href="">中国人民大学</a></li>
                    <li><a href="">中国人民大学</a></li>
                    <li><a href="">中国人民大学</a></li>
                    <li><a href="">中国航空航天大学</a></li>
                    <li><a href="">北京理工大学</a></li>
                    <li><a href="">中央名族大学</a></li>
                    <li><a href="">中国人民大学</a></li>
                    <li><a href="">中国人民大学</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
