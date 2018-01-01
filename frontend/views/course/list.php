<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\CourseCategory;

AppAsset::addCss($this,'@web/css/course.css');

$this->title = 'My Yii Application';
?>
<div class="college-list">
    <ul class="college-banner _college-banner">
        <li class="college-gy active"></li>
        <li class="college-health"></li>
        <li class="college-sf"></li>
        <li class="college-ms"></li>
        <li class="college-music"></li>
        <li class="college-sy"></li>
        <li class="college-wx"></li>
    </ul>
    <div class="college-content">
        <div class="college-category">
            <h3 class="college-all">全部学院</h3>
            <ul class="college-category-list _college-category-list">
                <li class="active">公益学院</li>
                <li>健康学院</li>
                <li>书法学院</li>
                <li>美术学院</li>
                <li>音乐学院</li>
                <li>摄影学院</li>
            </ul>
        </div>
        <div class="college-right">
            <ul class="college-tab _college-tab">
                <li class="active">
                    <span>学院介绍</span>
                </li>
                <li>
                    <span>课程列表</span>
                </li>
                <li>
                    <span>师资力量</span>
                </li>
            </ul>
            <ul class="college-category-con _college-category-con">
                <li class="college-intro active">
                    <p>建校六十多年来，学校逐步形成了“学风严谨，崇尚实践”的优良传统，为社会培养各类人才20余万人，大部分已成为国家政治、经济、科技、教育等领域尤其是冶金、材料行业的栋梁和骨干。党和国家领导人罗干、刘淇、徐匡迪、黄孟复、范长龙、郭声琨、刘晓峰等都曾在校学习，另有38名校友当选为中国科学院或中国工程院院士，一大批校友走上了省长、市长的领导岗位，一大批校友担任宝武集团、鞍钢集团、中国铝业、神华集团和新兴际华等国家特大型企业的董事长或总经理。学校被誉为“钢铁摇篮”。</p>
                    <p>学校位于高校云集的北京市海淀区学院路，占地约80.39万平方米（包括管庄校区），校舍建筑总面积97万平方米（包括管庄校区）。学校现有1个国家科学中心，1个“2011计划”协同创新中心，2个国家重点实验室，2个国家工程（技术）研究中心，2个国家科技基础条件平台，2个国家级国际科技合作基地，49个省、部级重点实验室、工程研究中心、国际合作基地、创新引智基地等。特别是2007年，学校作为第一所教育部直属高校牵头承担了国家重大科技基础设施项目——重大工程材料服役安全研究评价设施，并负责筹建国家材料服役安全科学中心。图书馆藏书超过203万册。定期出版《工程科学学报》、《北京科技大学学报（社会科学版）》、《International Journal of Minerals, Metallurgy and Materials》、《思想教育研究》、《物流技术与应用》、《金属世界》、《粉末冶金技术》等重要学术刊物。</p>
                </li>
                <li class="college-class">
                    <div class="user-course-list">
                        <div class="course-list-con">
                            <a href="" class="user-course-img"><img src="/img/course-list-img.jpg"/></a>
                            <div class="user-course-details">
                                <h3><a href="" title="" target="_blank">健康养生</a></h3>
                                <div class="row">主讲老师: 张老师</div>
                                <div class="row">
                                    <div class="btns">
                                        <a class="btn btn-primary" target="_blank" href="">进入学习</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="course-list-con">
                            <a href="" class="user-course-img"><img src="/img/course-list-img.jpg"/></a>
                            <div class="user-course-details">
                                <h3><a href="" title="" target="_blank">健康养生</a></h3>
                                <div class="row">主讲老师: 张老师</div>
                                <div class="row">
                                    <div class="btns">
                                        <a class="btn btn-primary" target="_blank" href="">进入学习</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="course-list-con">
                            <a href="" class="user-course-img"><img src="/img/course-list-img.jpg"/></a>
                            <div class="user-course-details">
                                <h3><a href="" title="" target="_blank">健康养生</a></h3>
                                <div class="row">主讲老师: 张老师</div>
                                <div class="row">
                                    <div class="btns">
                                        <a class="btn btn-primary" target="_blank" href="">进入学习</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="course-list-con">
                            <a href="" class="user-course-img"><img src="/img/course-list-img.jpg"/></a>
                            <div class="user-course-details">
                                <h3><a href="" title="" target="_blank">健康养生</a></h3>
                                <div class="row">主讲老师: 张老师</div>
                                <div class="row">
                                    <div class="btns">
                                        <a class="btn btn-primary" target="_blank" href="">进入学习</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="teacher-section">
                    <div class="teach-list">
                        <div class="teacher-con">
                            <a href="">
                                <img class="people-img" src="/img/teacher-people.png"/>
                                <p class="intro">
                                    <span class="name">张老师</span>
                                    <span class="work">中国人民大学教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                                    <span class="te-text">中国人民大学</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">职称职务:&nbsp;&nbsp;</span>
                                    <span class="te-text">教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                    <span class="te-text">人类健康</span>
                                </p>
                            </a>
                        </div>
                        <div class="teacher-con">
                            <a href="">
                                <img class="people-img" src="/img/teacher-people.png"/>
                                <p class="intro">
                                    <span class="name">张老师</span>
                                    <span class="work">中国人民大学教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                                    <span class="te-text">中国人民大学</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">职称职务:&nbsp;&nbsp;</span>
                                    <span class="te-text">教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                    <span class="te-text">人类健康</span>
                                </p>
                            </a>
                        </div>
                        <div class="teacher-con">
                            <a href="">
                                <img class="people-img" src="/img/teacher-people.png"/>
                                <p class="intro">
                                    <span class="name">张老师</span>
                                    <span class="work">中国人民大学教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                                    <span class="te-text">中国人民大学</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">职称职务:&nbsp;&nbsp;</span>
                                    <span class="te-text">教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                    <span class="te-text">人类健康</span>
                                </p>
                            </a>
                        </div>
                        <div class="teacher-con">
                            <a href="">
                                <img class="people-img" src="/img/teacher-people.png"/>
                                <p class="intro">
                                    <span class="name">张老师</span>
                                    <span class="work">中国人民大学教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">任职单位:&nbsp;&nbsp;</span>
                                    <span class="te-text">中国人民大学</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">职称职务:&nbsp;&nbsp;</span>
                                    <span class="te-text">教授</span>
                                </p>
                                <p class="intro">
                                    <span class="te-label">擅长领域:&nbsp;&nbsp;</span>
                                    <span class="te-text">人类健康</span>
                                </p>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="/js/course-list.js"></script>