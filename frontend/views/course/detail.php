<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\Course;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
AppAsset::addCss($this,'@web/css/course.css');

$this->title = '课程详情';
$userid = Yii::$app->user->id;
$course = $courseDetail['course'];
$cousechild = $courseDetail['coursechild'];
$share_title = '精品课程，超低优惠，快来学习吧！';
$share_url = Url::to(['course/detail', 'courseid'=>$course->id, 'invite'=>$userid], true);
$news = array(
    "PicUrl" =>'/img/share-logo.png',
    "Description"=>"活到老，学到老，快来和大家一起学习吧！",
    "Url" =>$share_url,
    'title' => $share_title
);
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span><a href="/course/list">课程列表</a></span>
        <span>&gt;</span>
        <span><?= $course->course_name; ?></span>
    </div>
</div>
<div class="container-course course-detail-section">
    <div class="container-inner">
        <div class="main-section">
            <input class="course-id _course-id" type="hidden" value="<?= $course->id; ?>"/>
            <div class="course-detail-left _course-detail-left" id="view">
                <img src="<?= $course->home_pic; ?>"/>
                <video id="course-video" controls src=""></video>
            </div>
            <div class="course-detail-right">
                <div class="course-detail-title"><?= $course->course_name; ?></div>
                <div class="course-sub-title"><?= $course->course_name; ?></div>
                <p class="course-price">
                    <span class="price-tag">现价</span>
                    <span class="price-highlight"><?= $course->discount ?>元</span>
                    <span class="price-tag">原价</span> <?= $course->price ?>元
                </p>
                <div class="course-info">课程信息</div>
                <ul class="info-list">
                    <li>
                        <img src="/img/tb_01.jpg"/>
                        <span>主讲&nbsp;&nbsp;<?= User::item($course->teacher_id); ?></span>
                    </li>
                    <li>
                        <img src="/img/tb_02.jpg"/>
                        <span>时长&nbsp;&nbsp;<?= $duration ?>分钟</span>
                    </li>
                    <li>
                        <img src="/img/tb_03.jpg"/>
                        <span>课时&nbsp;&nbsp;<?= ceil($duration/60) ?></span>
                    </li>
                    <li>
                        <img src="/img/tb_04.jpg"/>
                        <span>浏览&nbsp;&nbsp;<?= $course->view ?></span>
                    </li>
                    <!-- <li>
                        <img src="/img/tb_05.jpg"/>
                        <span>分享&nbsp;&nbsp;<?= $course->share ?></span>
                    </li> -->
                    <li>
                        <img src="/img/tb_06.jpg"/>
                        <span>收藏&nbsp;&nbsp;<label class="collection-num _collection-num"><?= $course->collection ?></label></span>
                    </li>
                </ul>
                <div class="share-like">
                    <p class="share-list">
                        <div class="share">
                            <div class="bdsharebuttonbox">
                                <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                            </div>
                            <script>
                                window._bd_share_config = {
                                "common":{
                                    "bdSnsKey":{},
                                    "bdText":'<?= $news["title"];?>',
                                    "bdDesc":'<?= $news["Description"];?>',
                                    "bdMini":"2",
                                    "bdPic":'<?= $news["PicUrl"];?>',
                                    "bdStyle":"0",
                                    "bdSize":"16",
                                    "bdUrl": '<?= $news["Url"];?>',
                                },
                                "share": {
                                    "bdSize": 32
                                },
                            };with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
                            </script>
                        </div>
                    </p>
                    <p class="share-list collection-btn _collection-btn">
                        <img src="/img/tb_08.jpg"/>
                        <span>收藏</span>
                    </p>
                </div>
                <?php
                    $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
                    $isschool = 0;
                    if (array_key_exists('school',$roles_array)) {
                        $isschool = 1;
                    }
                    $ismember = Course::ismember($course->id);
                    $ispay = Course::ispay($course->id);
                    if ($course->discount == 0) { ?>
                        <span class="course-ispay-tag">公开课程</span>
                    <?php }
                    else if ($ismember == 1) { ?>
                        <span class="course-ispay-tag">会员课程</span>
                    <?php }
                    else if ($ispay == 1 || $isschool == 1) { ?>
                        <span class="course-ispay-tag">已购课程</span>
                    <?php } else { ?>
                        <div class="btn-course">
                            <a class="quick-buy _quick-buy" href="javascript: void(0)">立即购买</a>
                            <a class="add-cart _add-cart" href="javascript: void(0)">加入购物车</a>
                        </div>
                <?php } ?>
            </div>
        </div>
        <div class="main-section">
            <div class="kc-left">
                <ul class="course-tag">
                    <li class="active">课程章节</li>
                    <li>课程介绍</li>
                    <li>课程评价</li>
                    <li>教师答疑</li>
                    <li>课程作业</li>
                    <li>辅导员</li>
                </ul>
                <div class="course-tag-content">
                    <div class="tag-content active">
                        <ul class="chapter-title">
                            <?php foreach ($cousechild as $key => $chapter) { ?>
                                <li class="active">
                                    <div class="chapter-title-name"><?= $chapter['chapter']->name ?></div>
                                    <ul class="chapter-con">
                                        <?php foreach ($chapter['chapterchild'] as $key => $section) { ?>
                                        <li>
                                            <?php
                                                $text = '';
                                                $current_time = date('Y-m-d H:i:s');
                                                $end_time = date('Y-m-d H:i:s',strtotime($section->start_time."+".$section->duration." minute"));
                                                //0 直播 2 直播答疑
                                                $video_url = $section->video_url;
                                                if ($section->type == 0 || $section->type == 2) {
                                                    if ($current_time < $section->start_time) {
                                                        $text = '最近直播：'.$section->start_time;
                                                    } else if ($current_time >= $section->start_time && $current_time < $end_time) {
                                                         $text = '直播中';
                                                    } else if ($current_time > $end_time) {
                                                        $text = '直播回放';
                                                    }
                                                } else if ($section->type == 1) {
                                                    $text = '点播课程';
                                                }
                                            ?>
                                            <?php 
                                                if ($section->type == 0 || $section->type == 2) { ?>
                                                    <a target="_blank" href="<?= $video_url ?>" class="chapter-list-name"><?= $section->name ?></a>
                                            <?php } else { ?>
                                                    <a href="javascript:void(0)" target="_blank" section-id="<?= $section->id ?>" class="chapter-list-name net-class _net-class"><?= $section->name ?></a>
                                            <?php } ?>
                                            <div class="chapter-list-time">
                                                <span class="time-tag"><?= $text ?></span>
                                                <span class="time-con"><?= $section->duration.'分钟' ?></span>
                                            </div>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="tag-content">
                        <?= $course->des; ?>
                    </div>
                    <div class="tag-content">
                        <div class="course-evaluate">
                            <textarea class="_course-evaluate-content"></textarea>
                            <button class="_course-evaluate-btn">提交</button>
                        </div>
                        <?php if (count($course_comments) > 0) { ?>
                        <ul class="evaluate-list _evaluate-list">
                            <?php foreach ($course_comments as $course_comment) { ?>
                                <li>
                                    <div class="user-info">
                                        <p class="user-img"><img src="<?= User::getUserModel($course_comment->user_id)->picture; ?>"/></p>
                                        <p class="user-name"><?= User::item($course_comment->user_id); ?></p>
                                    </div>
                                    <div class="user-evaluate">
                                        <p class="evaluate-info"><?= $course_comment->content ?></p>
                                        <p class="evaluate-time"><?= date('Y-m-d H:i:s', $course_comment->create_time) ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                    <div class="tag-content">
                        <div class="course-evaluate">
                            <textarea class="_course-question-content"></textarea>
                            <button class="_course-question-btn">我要提问</button>
                        </div>
                        <?php if (count($quas) > 0) { ?>
                        <ul class="user-question-list">
                            <?php foreach ($quas as $key => $qu) { ?>
                            <li>
                                <div class="question-content">
                                    <p class="question-answer">
                                        <span class="question-icon">问</span>
                                        <span class="question-txt"><?= $qu->question ?></span>
                                        <span class="question-date"><?= date('Y-m-d H:m:s', $qu->question_time) ?></span>
                                    </p>
                                    <p class="question-answer">
                                        <span class="question-icon">答</span>
                                        <span class="question-txt"><?= $qu->answer ?></span>
                                        <span class="question-date"><?= date('Y-m-d H:i:s', $qu->answer_time) ?></span>
                                    </p>
                                </div>
                            </li>
                             <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                    <div class="tag-content">
                        <?php if (count($datas) > 0) { ?>
                            <ul class="list data-ul active">
                                <?php foreach ($datas as $key => $course_data) { ?>
                                    <li>
                                        <div class="right-con">
                                            <p class="data-title">
                                                <?php if ($course_data->url_type == 1) {
                                                    $url = Url::to(['data/detail', 'dataid' => $course_data->id]);
                                                    $target = '_self';
                                                } else { 
                                                    $url = strip_tags($course_data->content);
                                                    $target = '_blank';
                                                } ?>
                                                <span><a class="data-title" target="<?= $target ?>" href="<?= $url ?>"><?= $course_data->name ?></a></span>
                                            </p>
                                            <p class="data-intro"><?= $course_data->summary ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p>暂无</p>
                        <?php } ?>
                    </div>
                    <div class="tag-content wechat">
                        <p>
                            <img src="<?= User::getUserModel($course->head_teacher)->wechat_img; ?>">
                        </p>
                        <p>微信号：<?= User::getUserModel($course->head_teacher)->wechat; ?></p>
                        <p>辅导员姓名：<?= User::getUserModel($course->head_teacher)->username; ?></p>
                    </div>
                </div>
            </div>
            <div class="kc-right">
                <div class="teacher-show">
                    <div class="teacher-img"><img src="<?= User::getUserModel($course->teacher_id)->picture; ?>"/></div>
                    <div class="teacher-detail">
                        <span class="name">教师： <?= User::item($course->teacher_id); ?></span>
                        <a href="<?= Url::to(['teacher/detail', 'userid' => $course->teacher_id]) ?>" class="view-btn">查看教师</a>
                    </div>
                    <div class="teacher-tag"><?= User::getUserModel($course->teacher_id)->description; ?></div>
                </div>
                <div class="teacher-info"><?= User::getUserModel($course->teacher_id)->intro; ?></div>
            </div>
            <div class="kc-right kc-right-student">
                <p class="student-title"><?= count($studyids) ?>人在学习该课程</p>
                <ul class="student-list">
                    <?php foreach ($studyids as $key => $studyid) { ?>
                        <li>
                            <p class="student-img">
                                <img src="<?= User::getUserModel($studyid)->picture; ?>"/>
                            </p>
                            <p class="student-name"><?= User::item($studyid) ?></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="<?= Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script src="<?= Url::to('@web/js/course-detail.js');?>"></script>
