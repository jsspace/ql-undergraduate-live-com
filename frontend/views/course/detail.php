<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\Course;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use backend\models\UserStudyLog;
use backend\models\CourseCategory;
AppAsset::addCss($this,'@web/css/main.css');
AppAsset::addCss($this,'@web/css/course.css');
AppAsset::addCss($this,'@web/css/list.css');

$this->title = '课程详情';
$userid = Yii::$app->user->id;
$course = $courseDetail['course'];
$sections = $courseDetail['sections'];
$classrooms = 0; //课堂学
$unit_test = 0; //单元测验
foreach ($sections as $key => $section) {
    if ($section->type == 1) {
        $classrooms++;
    } else if ($section->type == 0) {
         $unit_test++;
    }
}
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
        <!-- <video src="" controls="controls" loop="loop" x-webkit-airplay="true" webkit-playsinline="true" class="course-video"></video> -->
            <img src="<?= $course->home_pic ?>">
        </dt>
        <dd>
            <h4><?= $course->course_name ?></h4>
            <p class="bjxq1">价格： <code>￥<?= $course->discount ?></code>    原价： <del>￥<?= $course->price ?></del></p>
            <p><?= $course->online ?>人正在学习</p>
            <p>主讲：<?= User::item($course->teacher_id); ?></p>
            <p class="bjxq2"><code class="xq2now">课堂学<?= $classrooms ?>次</code><code>随堂练<?= $classrooms ?>次</code><code>模拟考<?= $course->examination_time ?>次</code></p>
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
                        <span class="course-ispay-tag">免费课程</span>
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
                <!-- <code class="colorfff"><a href="javascript: void(0)"><img src="/images/nyicon2.png" />分享</a></code> -->
                <code class="colorfff">
                    <a href="javascript: void(0)" class="share-list collection-btn _collection-btn"><img src="/images/nyicon2a.png" />收藏</a>
                </code></p>
        </dd>
    </dl>
    <div class="nytxt3 cc">
        <div class="nytxt3_l">
            <div class="nytxt3_lny1">
                <dl class="cc course-tag">
                    <dd><a href="javascript: void(0)">课程介绍</a></dd>
                    <?php 
                        if ($course->type === 1) {
                    ?>
                    <dd class="kcnow"><a href="javascript: void(0)">课堂入口</a></dd>
                    <!-- <dd><a href="javascript: void(0)">问老师</a></dd> -->
                    <dd><a href="javascript: void(0)">错题本</a></dd>
                    <dd><a href="javascript: void(0)">学情报告</a></dd>
                    <?php } ?>
                </dl>
            </div>
            <div class="course-tag-content">
                <div class="tag-content">
                    <?= $course->des; ?>
                </div>
                <div class="tag-content active nytxt3_lny1">
                    <ul class="chapter-title">
                        <?php foreach ($sections as $key => $section) {
                            /* 判断是否观看完 */
                            $study_log_complete = UserStudyLog::iscomplete($course->id, $section->id);
                            if ($study_log_complete) {
                                $percentage = '100%';
                            } else {
                                /* 获取学员观看日志 */
                                $study_log = UserStudyLog::find()
                                ->where(['userid' => $userid])
                                ->andWhere(['courseid' => $course->id])
                                ->andWhere(['sectionid' => $section->id])
                                ->orderBy('id desc')
                                ->one();
                                $current_time = 0;
                                if ($study_log) {
                                    $current_time = $study_log->current_time;
                                }
                                $seconds_arr = explode(':', $section->duration);
                                $seconds = $seconds_arr[0]*60 + $seconds_arr[1];
                                $percentage = number_format($current_time/$seconds, 2, '.', '')*100;
                                $percentage = $percentage.'%';
                            }
                        ?>
                            <li section-id="<?= $section->id ?>">
                                <div class="play-bar">
                                    <div class="chapter-title-left">
                                        <div class="chapter-list-ctrl _upload-ctr"></div>
                                        <a href="javascript:void(0)" target="_blank" class="chapter-list-name net-class _net-class"><?= $section->name ?></a>
                                    </div>
                                    <div class="chapter-list-time">
                                        <a href="javascript:void(0)" class="haveLearn">已学<?= $percentage ?></a>
                                        <a href="javascript:void(0)" target="_blank" class="play-icon _net-class"><?= $section->duration ?></a>
                                    </div>
                                </div>
                                <div class="upload-bar" style="display: none">
                                    <div class="upload-btn _exam">课堂测试/查看答卷</div>
                                    <div class="upload-btn _exam-error">错题本</div>
                                    <!-- <div class="upload-btn _exercise">随堂练习</div>
                                    <div class="upload-btn _upload-answer">上传答题</div>
                                    <div class="upload-btn _answer">习题答案</div>
                                    <div class="upload-btn _explain">习题讲解</div> -->
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- <div class="tag-content">
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
                </div> -->
                <div class="tag-content">
                    <table class="gridtable">
                        <tr>
                            <th>节次</th>
                            <th>错题本</th>
                        </tr>
                        <tr>
                            <td>第一节：升本政策解读</td>
                            <td><a href="www.baidu.com" target="_blank">第一节错题本</a></td>
                        </tr>
                    </table>
                </div>
                <div class="tag-content xueqing">
                    <h4 class="xueqing-title"><?= $course->course_name ?>（正确大于80%为优秀，60%--80%为良好，小于60%为一般）</h4>
                    <p>共计 <label>60</label> 次考试，你参加考试 <label>4</label> 次，还有 <label>56</label> 次未考;</p>
                    <p>正确率：<label>89%</label>，超过了 <label>78%</label> 的同学，你的总评为优秀</p>
                    <h4 class="xueqing-title">详细列表：</h4>
                    <ul class="xueqing-list">
                        <li>
                            <span>第一讲：虚拟语气</span>
                            <label>84分</label>
                        </li>
                        <li>
                            <span>第二讲：倒装句</span>
                            <label>84分</label>
                        </li>
                        <li>
                            <span>第三讲：分词</span>
                            <label>60分</label>
                        </li>
                        <li>
                            <span>第四讲：状语从句</span>
                            <label>95分</label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="nytxt3_r">
            <div class="nytxt3_rny1">
                <h4>主讲老师</h4>
                <?php
                    $id_arr = explode(',', $course->teacher_id);
                    foreach ($id_arr as $key => $id) {
                        $teacher = User::getUserModel($id);
                        $teacher_pictrue = '';
                        if ($teacher) {
                            $teacher_pictrue = $teacher->picture;
                        }
                    ?>
                        <div class="teacher-item">
                            <div class="left">
                                <img class="teacher-img" src="<?= $teacher_pictrue; ?>" />
                            </div>
                            <div class="right">
                                <p class="rny1name" title="<?= $teacher->username; ?>"><?= $teacher->username; ?></p>
                                <p title="<?= $teacher->description; ?>"><?= $teacher->description; ?></p>
                                <p title="<?= $teacher->office; ?>"><?= $teacher->office; ?></p>
                            </div>
                        </div>
                <?php } ?>
            </div>
            <!-- <?php
                $hteacher = User::getUserModel($course->head_teacher);
                if (!empty($hteacher)) { ?>
                <dl class="nytxt3_rny1">
                    <dt>
                        <img class="head-teacher-wechat" src="<?= $hteacher->wechat_img ?>" />
                    </dt>
                    <dd>
                        <h4>班主任</h4>
                        <p class="rny1name"><?= $hteacher->username; ?></p>
                        <p><?= $hteacher->description; ?></p>
                        <p><?= $hteacher->office; ?></p>
                    </dd>
                </dl>
            <?php } ?>
            <?php
                $course_cat = CourseCategory::find()
                ->select('tutor')
                ->where(['id' => $course->category_name])
                ->one();
                $tutor_arr = explode(',', $course_cat->tutor);
                if (count($tutor_arr) != 0) {
            ?>
            <div class="nytxt3_rny2 cc">
                <h3>辅导老师</h3>
                <ul>
                   <?php foreach ($tutor_arr as $key => $tutor) {
                        $user = User::getUserModel($tutor);
                        if (!empty($user)) { ?>
                            <li><a href="#"><img src="<?= $user->picture ?>" width="63"/><p><?= $user->username ?></p></a></li>
                    <?php } } ?>
                </ul>
            </div>
            <?php } ?>
            <div class="kc-right kc-right-student">
                <p class="student-title"><?= count($studyids) ?>人在学习该课程</p>
                <ul class="student-list">
                    <?php foreach ($studyids as $key => $studyid) { 
                        if (!empty(User::getUserModel($studyid))) {
                    ?>
                        <li>
                            <p class="student-img">
                                <img src="<?= User::getUserModel($studyid)->picture; ?>"/>
                            </p>
                            <p class="student-name"><?= User::item($studyid) ?></p>
                        </li>
                    <?php } } ?>
                </ul>
            </div> -->
        </div>
    </div>
</div>
<div class="video-layout _video-layout">
    <div class="video-box _video-box">
        <div class="_close-video-btn close-video-btn">
            <img src="//static-cdn.ticwear.com/cmww/statics/img/product/mini/mini-confirm-close-btn.png">
        </div>
        <!-- <iframe id="course-video" width="100%" height="100%" src="" frameborder="0" allowfullscreen=""></iframe> -->
        <video id="course-video" width="100%" height="100%" controls="controls"></video>
        <video id="course-explain" width="100%" height="100%" controls="controls"></video>
    </div>
</div>

<script src="<?= Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script src="<?= Url::to('@web/js/course-detail.js?v=1');?>"></script>