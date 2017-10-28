<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;

AppAsset::addCss($this,'@web/css/course.css');

$this->title = 'My Yii Application';
$userid = Yii::$app->user->id;
?>
<?php
    $course = $courseDetail['course'];
    $cousechild = $courseDetail['coursechild'];
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span><a href="/course/list">课程列表</a></span>
    <span>&gt;</span>
    <span><?= $course->course_name; ?></span>
</div>
<div class="container-course course-detail-section">
    <div class="main-section">
        <input class="course-id _course-id" type="hidden" value="<?= $course->id; ?>"/>
        <div class="course-detail-left">
            <img src="<?= $course->home_pic; ?>"/>
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
                    <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt" target="_blank">
                        <img src="/img/tb_07.jpg"/>
                        <span>分享</span>
                    </a>
                </p>
                <p class="share-list collection-btn _collection-btn">
                    <img src="/img/tb_08.jpg"/>
                    <span>收藏</span>
                </p>
            </div>
            <div class="btn-course">
                <a class="quick-buy _quick-buy" href="javascript: void(0)">立即购买</a>
                <a class="add-cart _add-cart" href="javascript: void(0)">加入购物车</a>
            </div>
        </div>
    </div>
    <div class="main-section">
        <div class="kc-left">
            <ul class="course-tag">
                <li class="active">课程章节</li>
                <li>课程详情</li>
                <li>课程评价</li>
                <li>教师答疑</li>
                <li>课程资料</li>
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
                                        <img src="/img/chapter-play-icon.png"/>
                                        <a target="_blank" href="<?= $section->video_url ?>" class="chapter-list-name"><?= $section->name ?></a>
                                        <div class="chapter-list-time">
                                            <?php
                                                $text = '';
                                                $current_time = date('Y-m-d H:i:s');
                                                $end_time = date('Y-m-d H:i:s',strtotime($section->start_time."+".$section->duration." minute"));
                                                //0 直播
                                                if ($section->type == 0) {
                                                    if ($current_time < $section->start_time) {
                                                        $text = '最近直播：'.$section->start_time;
                                                    } else if ($current_time >= $section->start_time && $current_time < $end_time) {
                                                         $text = '直播中';
                                                    } else if ($current_time > $end_time) {
                                                        $text = '直播回放';
                                                    }
                                                } else {
                                                    $text = '点播课程';
                                                }
                                            ?>
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
                    <ul class="evaluate-list _evaluate-list">
                        <?php foreach ($course_comments as $course_comment) { ?>
                            <li>
                                <div class="user-info">
                                    <p class="user-img"><img src="<?= User::getUserModel($course_comment->user_id)->picture; ?>"/></p>
                                    <p class="user-name"><?= User::item($course->teacher_id); ?></p>
                                </div>
                                <div class="user-evaluate">
                                    <p class="evaluate-info"><?= $course_comment->content ?></p>
                                    <p class="evaluate-time"><?= date('Y-m-d H:i:s', $course_comment->create_time) ?></p>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="tag-content">
                教师答疑
                </div>
                <div class="tag-content">
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
    </div>
</div>
<script src="<?= Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
<script src="<?= Url::to('@web/js/course-detail.js');?>"></script>
