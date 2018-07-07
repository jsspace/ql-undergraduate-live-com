<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\Course;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
AppAsset::addCss($this,'@web/css/main.css');
AppAsset::addCss($this,'@web/css/course.css');

$this->title = '课程详情';
$userid = Yii::$app->user->id;
$course = $courseDetail['course'];
$sections = $courseDetail['sections'];
$share_title = '精品课程，超低优惠，快来学习吧！';
$share_url = 'http://www.kaoben.top/course/detail?courseid='.$course->id.'&invite='.$userid;
$news = array(
    "PicUrl" =>'http://www.kaoben.top/img/share-logo.png',
    "Description"=>"活到老，学到老，快来和大家一起学习吧！",
    "Url" =>$share_url,
    'title' => $share_title
);
?>
<input class="course-id _course-id" type="hidden" value="<?= $course->id; ?>"/>
<input class="is_guest" type="hidden" value="<?= Yii::$app->user->isGuest; ?>"/>
<div class="main cc" style="padding:35px 0;">
    <dl class="nytxt2">
        <dt>
        <video src="" controls="controls" loop="loop" x-webkit-airplay="true" webkit-playsinline="true" class="course-video"></video>
        </dt>
        <dd>
            <h4><?= $course->course_name ?></h4>
            <p class="bjxq1">价格： <code>￥<?= $course->discount ?></code>    原价： <del>￥<?= $course->price ?></del></p>
            <p><?= $course->online ?>人正在学习</p>
            <p>主讲：<?= User::item($course->teacher_id); ?></p>
            <p class="bjxq2"><code class="xq2now">课堂学<?= count($sections) ?>次</code><code>随堂练<?= count($sections) ?>次</code><code>模拟考<?= $course->examination_time ?>次</code></p>
            <p class="bjxq3">
                <?php
                    $roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
                    $isschool = 0;
                    if (array_key_exists('school',$roles_array)) {
                        $isschool = 1;
                    }
                    $ismember = Course::ismember($course->id, Yii::$app->user->id);
                    $ispay = Course::ispay($course->id, Yii::$app->user->id);
                    if ($course->discount == 0) { ?>
                        <span class="course-ispay-tag">公开课程</span>
                    <?php }
                    else if ($ismember == 1) { ?>
                        <span class="course-ispay-tag">会员课程</span>
                    <?php }
                    else if ($ispay == 1 || $isschool == 1) { ?>
                        <span class="course-ispay-tag">已购课程</span>
                    <?php } else { ?>
                        <span>
                            <a class="quick-buy _quick-buy" href="javascript: void(0)">购买课程</a>
                        </span>
                        <span><a class="add-cart _add-cart" href="javascript: void(0)">加入购物车</a></span>
                <?php } ?>
                <code class="colorfff"><a href="javascript: void(0)"><img src="/images/nyicon2.png" />分享</a></code><code class="colorfff"><a href="javascript: void(0)" class="share-list collection-btn _collection-btn"><img src="/images/nyicon2a.png" />收藏</a></code></p>
        </dd>
    </dl>
    <div class="nytxt3 cc">
        <div class="nytxt3_l">
            <div class="nytxt3_lny1">
                <dl class="cc course-tag">
                    <dd><a href="javascript: void(0)">课程介绍</a></dd>
                    <dd class="kcnow"><a href="javascript: void(0)">课堂入口</a></dd>
                    <dd><a href="javascript: void(0)">问老师</a></dd>
                    <dd><a href="javascript: void(0)">错题本</a></dd>
                    <dd><a href="javascript: void(0)">学情报告</a></dd>          
                </dl>
            </div>
            <div class="course-tag-content">
                <div class="tag-content">
                    <?= $course->des; ?>
                </div>
                <div class="tag-content active nytxt3_lny1">
                    <ul class="chapter-title">
                        <?php foreach ($sections as $key => $section) { ?>
                            <li>
                                <a href="javascript:void(0)" target="_blank" section-id="<?= $section->id ?>" class="chapter-list-name net-class _net-class"><?= $section->name ?></a>
                                <div class="chapter-list-time">
                                    <span class="time-con"><?= $section->duration ?></span>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
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
                    错题本
                </div>
                <div class="tag-content">
                    学情报告
                </div>
            </div>
        </div>
        <div class="nytxt3_r">
            <dl class="nytxt3_rny1">
                <?php
                    $teacher = User::getUserModel($course->teacher_id);
                    $teacher_pictrue = '';
                    if ($teacher) {
                        $teacher_pictrue = $teacher->picture;
                    }
                ?>
                <dt><img class="teacher-img" src="<?= $teacher_pictrue; ?>" /></dt>
                <dd>
                    <h4>主讲老师</h4>
                    <p class="rny1name"><?= User::item($course->teacher_id); ?></p>
                    <p><?= User::getUserModel($course->teacher_id)->description; ?></p>
                    <p><?= User::getUserModel($course->teacher_id)->office; ?></p>
                </dd>
            </dl>
            <dl class="nytxt3_rny1">
                <?php
                    $hteacher = User::getUserModel($course->head_teacher);
                    $hteacher_pictrue = '';
                    if ($hteacher) {
                        $hteacher_pictrue = $hteacher->picture;
                    }
                ?>
                <dt><img class="head-teacher-img" src="<?= $hteacher_pictrue; ?>" /></dt>
                <dd>
                    <h4>主讲老师</h4>
                    <p class="rny1name"><?= User::item($course->head_teacher); ?></p>
                    <p><img class="head-teacher-wechat" src="<?= $hteacher->wechat_img ?>" width="50" /></p>
                </dd>
            </dl>
            <div class="nytxt3_rny2 cc">
                <h3>辅导老师</h3>
                <ul>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                    <li><a href="#"><img src="/images/nypic3.jpg" width="63" height="84" /><p>susu</p></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="<?= Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script src="<?= Url::to('@web/js/course-detail.js');?>"></script>