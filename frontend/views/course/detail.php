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
$chapters = $course->courseChapters;
$classrooms = 0; //课堂学
$homeworks = 0; //随堂练（作业）
$unit_test = count($chapters); //单元测验
foreach ($chapters as $key => $chapter) {
    $sections = $chapter->courseSections;
    $homeworks += count($sections);
    foreach ($sections as $key => $section) {
        $points = $section->courseSectionPoints;
        $classrooms += count($points);
    }
}
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
            <h4 title="<?= $course->course_name ?>"><?= $course->course_name ?></h4>
            <p class="bjxq1">价格： <code>￥<?= $course->discount ?></code>    原价： <del>￥<?= $course->price ?></del></p>
            <p><?= $course->online ?>人正在学习</p>
            <p>主讲：<?= User::item($course->teacher_id); ?></p>
            <p class="bjxq2"><code class="xq2now">课堂学<?= $classrooms ?>次</code><code>随堂练<?= $homeworks ?>次</code><code>单元测试<?= $unit_test ?>次</code></p>
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
                    <dd><a href="javascript: void(0)">学情报告</a></dd>
                    <?php } ?>
                </dl>
            </div>
            <div class="course-tag-content">
                <div class="tag-content">
                    <?= $course->des; ?>
                </div>
                <div class="tag-content active nytxt3_lny1">
                    <?php foreach ($chapters as $key => $chapter) { ?>
                        <div class="chapter-item">
                            <h3 class="chapter-title"><?= $chapter->name ?></h3>
                            <ul>
                                <?php foreach ($chapter->courseSections as $key => $section) { ?>
                                <li class="section-list">
                                    <h3 class="section-title"><?= $section->name ?></h3>
                                    <ul>
                                         <?php foreach ($section->courseSectionPoints as $key => $point) {
                                        /* 判断是否观看完 */
                                        $study_log_complete = UserStudyLog::iscomplete($course->id, $point->id);
                                        if ($study_log_complete) {
                                            $percentage = '100%';
                                        } else {
                                            /* 获取学员观看日志 */
                                            $study_log = UserStudyLog::find()
                                            ->where(['userid' => $userid])
                                            ->andWhere(['courseid' => $course->id])
                                            ->andWhere(['pointid' => $point->id])
                                            ->orderBy('id desc')
                                            ->one();
                                            $current_time = 0;
                                            if ($study_log) {
                                                $current_time = $study_log->current_time;
                                            }
                                            $points_arr = explode(':', $point->duration);
                                            $seconds = $points_arr[0]*60 + $points_arr[1];
                                            $percentage = number_format($current_time/$seconds, 2, '.', '')*100;
                                            $percentage = $percentage.'%';
                                        }
                                        ?>
                                        <li class="point-list _net-class" data-value="<?= $point->id ?>">
                                            <div class="left">
                                                <a href="javascript:void(0)" target="_blank" class="chapter-list-name net-class"><?=$point->name ?></a>
                                            </div>
                                            <div class="right">
                                                <a href="javascript:void(0)" class="haveLearn">已学<?= $percentage ?></a>
                                                <a href="javascript:void(0)" target="_blank" class="play-icon"><?= $point->duration ?></a>
                                            </div>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <div class="tag-content xueqing">
                    <ul class="title">
                        <li>单元</li>
                        <li>试卷名称</li>
                        <li>得分</li>
                        <li>状态</li>
                        <li>操作</li>
                    </ul>
                    <ul>
                        <li title="">第一单元：函数状态连续</li>
                        <li title="">函数极限连续单元测试</li>
                        <li>90</li>
                        <li>已通关</li>
                        <li>查看试卷</li>
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