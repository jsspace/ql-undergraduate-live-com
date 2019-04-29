<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\Course;
use backend\models\UserHomework;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use backend\models\UserStudyLog;
use backend\models\CourseCategory;
use backend\models\Lookup;
AppAsset::addCss($this,'@web/css/main.css');
AppAsset::addCss($this,'@web/css/course.css');
AppAsset::addCss($this,'@web/css/list.css');

$this->title = '课程详情';
$userid = Yii::$app->user->id;
$chapters = $course->courseChapters;
$classrooms = 0; //课堂学
$homeworks = 0; //随堂练（作业）
$unit_test = count($chapters); //单元测验
$sections = '';
$homework_submit_count = 0;
$imgs = '';
$homework_info = '';
foreach ($chapters as $key => $chapter) {
    $sections = $chapter->courseSections;
    $homeworks += count($sections);
    foreach ($sections as $key => $section) {
        $points = $section->courseSectionPoints;
        $classrooms += count($points);
        $temp = UserHomework::find()->where(['user_id' => $userid, 'section_id' => $section->id, 'status' => 2])->one();
        if ($temp) {$homework_submit_count = $homework_submit_count + 1;}
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
            <p class="valid-date">课程有效期至2020年3月20日</p>
            <p class="course-update-tip">课程已更新至<?= $classrooms ?>讲</p>
            <!-- <p><?= $course->online ?>人正在学习</p> -->
            <!-- <p>主讲：<?= User::item($course->teacher_id); ?></p> -->
            <p class="bjxq2"><code class="xq2now">视频<?= $classrooms ?>讲</code><code>作业<?= $homeworks ?>次</code><code>测试<?= $unit_test ?>次</code></p>
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
                    <dd class="kcnow"><a href="javascript: void(0)">课堂视频</a></dd>
                    <?php 
                        if ($course->type === 1) {
                    ?>
                    <dd><a href="javascript: void(0)">课堂作业</a></dd>
                    <dd><a href="javascript: void(0)">单元测试</a></dd>
                    <dd><a href="javascript: void(0)">答疑</a></dd>
                    <?php } ?>
                </dl>
            </div>
            <div class="course-tag-content">
                <div class="tag-content">
                    <?= $course->des; ?>
                </div>
                <div class="tag-content nytxt3_lny1 active">
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
                                            if (!empty($point->duration)) {
                                                $points_arr = explode(':', $point->duration);
                                                $seconds = $points_arr[0]*60;
                                                if (!empty($points_arr[1])) {
                                                    $seconds = $seconds + $points_arr[1];
                                                }
                                                $percentage = number_format($current_time/$seconds, 2, '.', '')*100;
                                            } else {
                                                $percentage = 0;
                                            }
                                            $percentage = $percentage.'%';
                                        }
                                        ?>
                                        <li class="point-list _net-class" data-value="<?= $point->id ?>">
                                            <div class="left">
                                                <a href="javascript:void(0)" target="_blank" class="chapter-list-name net-class"><?=$point->name ?></a>
                                                <?php if ($point->paid_free == 0) { ?>
                                                    <span id="is_free" class="free-video">试看</span>
                                                <?php } ?>
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
                <div class="tag-content zuoye">

                    <?php if (!empty(Yii::$app->user->identity)){ ?>
                    <p>
                        <span>应交：</span><label><?=$homeworks?>（次）</label>
                        <span>实交：</span><label><?=$homework_submit_count ?>（次）</label>
                    </p>
                    <?php } ?>

                    <ul class="title">
                        <li>节次</li>
                        <li>作业任务</li>
                        <li>提交作业</li>
                        <li>作业讲解</li>
                        <li>状态</li>
                        <li>提交时间</li>
                    </ul>
                    <?php
                    foreach ($chapters as $key => $chapter) {
                        foreach ($chapter->courseSections as $key => $section) {
                            $flag = false;
                            $homework_info = '';
                            $homework_info = UserHomework::find()
                            ->where(['user_id' => $userid, 'section_id' => $section->id, 'submit_time'=>
                                UserHomework::find()->where(['user_id' => $userid, 'section_id' => $section->id])->max('submit_time')])->one();
                            if (!empty($homework_info)){
                                $flag = true;
                            }

                    ?>
                            <ul>
                                <li><?=$section->name ?></li>
                                <li><?=$section->homework ?></li>
                                <li>
                                        <?php if ($flag and $homework_info->status!=3){ ?>
                                            <?php $imgs=explode(';', $homework_info->pic_url);
                                                    $imgs = array_filter($imgs);
                                                   foreach ($imgs as $img){

                                            ?>
                                            <a href="<?=$img ?>" target="_blank"><img style="width: 60px; display: block" src="<?=$img ?>"></a>
                                        <?php }}else{ $disabled = ''; if (empty($section->homework)) {$disabled = 'disabled';}?>
                                            <button <?=$disabled ?> class="zuoye_button" onclick="tips(<?=$section->id ?>, <?=$userid ?>);" >作业上传</button>
                                        <?php } ?>
                                </li>
                                <li>
                                    <a id="explain" video_src="<?=$section->explain_video_url ?>" status="<?= $homework_info ? $homework_info->status : 0 ?>">作业讲解</a>
                                </li>
                                <li>
                                    <?php if ($homework_info) {?>
                                    <?=Lookup::item('homework_status', $homework_info->status) ?>
                                    <?php }else {?>
                                    未提交
                                    <?php } ?>
                                </li>
                                <li>
                                    <?php if ($homework_info) {?>
                                    <?=$homework_info->submit_time ?>
                                    <?php }else {?>
                                        --
                                    <?php } ?>
                                </li>
                            </ul>
                    <?php } }?>

                </div>
                <div class="tag-content xueqing">
                    <?php 
                        $access_token = '';
                        if (!empty(Yii::$app->user->identity)) {
                            $access_token = Yii::$app->user->identity->access_token;
                            // 获取学情
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, "https://exam.kaoben.top/?r=apitest/getexambyuser&userid=$userid&courseid=$course->id");
                            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
                            $xueqing = curl_exec($curl);
                            curl_close($curl); 
                            $xueqing = json_decode($xueqing);
                    ?>
                    <p>
                        <span>应考：</span><label><?=$xueqing->examnum?>（次）</label>
                        <span>过关：</span><label><?=$xueqing->examuser?>（次）</label>
                    </p>
                    <ul class="title">
                        <li>单元</li>
                        <li>试卷名称</li>
                        <li>得分</li>
                        <li>状态</li>
                        <li>操作</li>
                    </ul>
                    <?php foreach ($xueqing->list as $key => $value) {
                        if ($value->status === 1) {
                            $statusClass = 'status-pass';
                            $statusText = '已通关';
                            $viewText = '查看答卷';
                            $viewClass='';
                            $examUrl = $value->link.'&token='.$access_token;
                        } else if ($value->status === 2) {
                            $statusClass = 'status-nopass';
                            $statusText = '未通关';
                            $viewText = '立即答题';
                            $viewClass='answer-url';
                            $examUrl = $value->link.'&token='.$access_token;
                        } else {
                            $statusClass = 'status-ing';
                            $statusText = '批阅中';
                            $viewText = '请耐心等待';
                            $viewClass='';
                            $examUrl = 'javascript: void(0)';
                        }
                    ?>
                        <ul>
                            <li title="<?=$value->chapterName?>"><?=$value->chapterName?></li>
                            <li title="<?=$value->examName?>"><?=$value->examName?></li>
                            <li>
                                <span class="<?=$statusClass?>"><?=$value->score?></span>
                            </li>
                            <li>
                                <span class="<?=$statusClass?>"><?=$statusText?></span>
                            </li>
                            <li>
                                <a class="<?=$viewClass?>" target="_blank" href="<?=$examUrl?>"><?=$viewText?></a>
                            </li>
                        </ul>
                    <?php } ?>
                <?php } else { ?>
                    <div class="no-login">登录后可见~</div>
                <?php } ?>
                </div>
                <div class="tag-content qa">
                    <p>关注公众号“都想学考本帮”，进入手机端网站进行答疑</p>
                    <img src="/images/public-erweima.jpg" alt="">
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
                        $username = '';
                        $description = '';
                        $office = '';
                        if ($teacher) {
                            $teacher_pictrue = $teacher->picture;
                            $username = $teacher->username;
                            $description = $teacher->description;
                            $office = $teacher->office;
                        }
                    ?>
                        <div class="teacher-item">
                            <div class="left">
                                <img class="teacher-img" src="<?= $teacher_pictrue; ?>" />
                            </div>
                            <div class="right">
                                <p class="rny1name" title="<?= $username; ?>"><?= $username; ?></p>
                                <p title="<?= $description; ?>"><?= $description; ?></p>
                                <p title="<?= $office; ?>"><?= $office; ?></p>
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

<script src="<?= Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script src="<?= Url::to('@web/js/course-detail.js?v=1');?>"></script>
<script type="text/javascript">
    var section_id = '';
    function tips(sec_id, user_id) {
        if (user_id == null) {
            window.location.href = '/site/login';
        } else {
            section_id = sec_id;
            upload_select = '<div>\n' +
                '<input type="file" id="fileloader"  name="file" multiple />\n' +
                '</div><div><input style="margin-top:50px; width:80px; height:30px;" type="button" id="upload" value="上传" /></div>';
            layer.open({
                title: '请选择要上传的作业',
                type: 1,
                skin: 'layui-layer-demo', //样式类名
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                content: upload_select,
                area: ['500px', '300px']
            });
        }
    }

    function homeworkVideoEvent() {
        var src = $(this).attr('video_src');
        $('._video-layout').show();
        $('#course-explain').hide().attr('src', '');
        $('#course-video').show().attr('src', src);
        $('#course-video').get(0).play();
    }
</script>