<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\Course;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use backend\models\UserStudyLog;
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
                            print_r($percentage);
                        ?>
                            <li>
                                <div class="play-bar">
                                    <div class="chapter-title-left">
                                        <div class="chapter-list-ctrl _upload-ctr"></div>
                                        <a href="javascript:void(0)" target="_blank" section-id="<?= $section->id ?>" class="chapter-list-name net-class _net-class"><?= $section->name ?></a>
                                    </div>
                                    <div class="chapter-list-time">
                                        <a href="javascript:void(0)" target="_blank" section-id="<?= $section->id ?>" class="play-icon"><?= $section->duration ?></a>
                                    </div>
                                </div>
                                <div class="upload-bar" style="display: none">
                                        <div class="upload-btn _exercise">随堂练习</div>
                                        <div class="upload-btn _upload-answer">上传答题</div>
                                        <div class="upload-btn _answer">习题答案</div>
                                        <div class="upload-btn _explain">习题讲解</div>
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
                    <ul>
                        <li class="err-list">
                            <div class="err-header">
                                <div class="err-course-title">知识点一：公文写作</div>
                                <div class="err-course-date">张翼德老师</div>
                                <div class="err-course-date">2018年7月10日</div>
                            </div>
                            <div class="err-content">
                                7月4日，当尚处于点映期的《我不是药神》在豆瓣出分时，不少人是吃惊的。

                                一惊讶时间，由于点映规模有限，大多数电影都无法在此期间达到足够的有效分数。

                                二惊讶于分数本身，对于在豆瓣拿7、8分较难的国产电影来说，9.0简直是个天文数字，上一部9分以上的国产电影还要追溯到2002年的《无间道》。
                            </div>
                        </li>
                        <li class="err-list">
                            <div class="err-header">
                                <div class="err-course-title">知识点一：公文写作</div>
                                <div class="err-course-date">张翼德老师</div>
                                <div class="err-course-date">2018年7月10日</div>
                            </div>
                            <div class="err-content">
                                7月4日，当尚处于点映期的《我不是药神》在豆瓣出分时，不少人是吃惊的。

                                一惊讶时间，由于点映规模有限，大多数电影都无法在此期间达到足够的有效分数。

                                二惊讶于分数本身，对于在豆瓣拿7、8分较难的国产电影来说，9.0简直是个天文数字，上一部9分以上的国产电影还要追溯到2002年的《无间道》。
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tag-content">
                    <ul>
                        <li class="err-list">
                            <div class="err-header">
                                <div class="err-course-title">知识点一：公文写作</div>
                                <div class="err-course-date">张翼德老师</div>
                                <div class="err-course-date">2018年7月10日</div>
                            </div>
                            <div class="err-content">
                                7月4日，当尚处于点映期的《我不是药神》在豆瓣出分时，不少人是吃惊的。

                                一惊讶时间，由于点映规模有限，大多数电影都无法在此期间达到足够的有效分数。

                                二惊讶于分数本身，对于在豆瓣拿7、8分较难的国产电影来说，9.0简直是个天文数字，上一部9分以上的国产电影还要追溯到2002年的《无间道》。
                            </div>
                        </li>
                        <li class="err-list">
                            <div class="err-header">
                                <div class="err-course-title">知识点一：公文写作</div>
                                <div class="err-course-date">张翼德老师</div>
                                <div class="err-course-date">2018年7月10日</div>
                            </div>
                            <div class="err-content">
                                7月4日，当尚处于点映期的《我不是药神》在豆瓣出分时，不少人是吃惊的。

                                一惊讶时间，由于点映规模有限，大多数电影都无法在此期间达到足够的有效分数。

                                二惊讶于分数本身，对于在豆瓣拿7、8分较难的国产电影来说，9.0简直是个天文数字，上一部9分以上的国产电影还要追溯到2002年的《无间道》。
                            </div>
                        </li>
                        <li class="err-list">
                            <div class="err-header">
                                <div class="err-course-title">知识点一：公文写作</div>
                                <div class="err-course-date">张翼德老师</div>
                                <div class="err-course-date">2018年7月10日</div>
                            </div>
                            <div class="err-content">
                                7月4日，当尚处于点映期的《我不是药神》在豆瓣出分时，不少人是吃惊的。

                                一惊讶时间，由于点映规模有限，大多数电影都无法在此期间达到足够的有效分数。

                                二惊讶于分数本身，对于在豆瓣拿7、8分较难的国产电影来说，9.0简直是个天文数字，上一部9分以上的国产电影还要追溯到2002年的《无间道》。
                            </div>
                        </li>
                    </ul>
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
                    <p class="rny1name"><?= $teacher->username; ?></p>
                    <p><?= $teacher->description; ?></p>
                    <p><?= $teacher->office; ?></p>
                </dd>
            </dl>
            <?php
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
<div class="video-layout _video-layout">
    <div class="video-box _video-box">
        <div class="_close-video-btn close-video-btn">
            <img src="//static-cdn.ticwear.com/cmww/statics/img/product/mini/mini-confirm-close-btn.png">
        </div>
        <!-- <iframe id="course-video" width="100%" height="100%" src="" frameborder="0" allowfullscreen=""></iframe> -->
        <video id="course-video" width="100%" height="100%" controls="controls"></video>
    </div>
</div>

<script src="<?= Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script src="<?= Url::to('@web/js/course-detail.js');?>"></script>