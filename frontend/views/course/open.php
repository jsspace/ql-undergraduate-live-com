<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use yii\widgets\LinkPager;

AppAsset::addCss($this,'@web/css/list.css');

$this->title = '公开课';
?>
<div class="container-course course-online">
    <div class="container-course-wrap">
        <div class="course-content">
            <ul class="list">
                <?php foreach ($courses as $course) { ?>
                    <li>
                        <a href="javascript: void(0)">
                            <div class="course-img">
                                <div class="bg"></div>
                                <span data-url="<?= $course->open_course_url ?>" class="video-play-btn"></span>
                                <img class="course-pic" src="<?= $course->list_pic; ?>"/>
                            </div>
                            <span class="content-title"><?= $course->course_name; ?></span>
                            <span class="course-time"><?= date('Y-m-d H:i', $course->create_time); ?></span>
                        </a>
                        <div class="teacher-section">
                            <!-- <img src="<?= User::getUserModel($course->teacher_id)->picture; ?>"/> -->
                            <span class="teacher-name">主讲人：<?= User::item($course->teacher_id); ?></span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <div class="clear"></div>
            <?php 
                echo LinkPager::widget([
                    'pagination' => $pages,
                    'firstPageLabel'=>"首页",
                    'lastPageLabel'=>'尾页',
                ]);
            ?>
        </div>
    </div>
</div>
<div class="video-layout _video-layout">
    <div class="video-box _video-box">
        <div class="_close-video-btn close-video-btn">
            <img src="//static-cdn.ticwear.com/cmww/statics/img/product/mini/mini-confirm-close-btn.png">
        </div>
        <iframe width="100%" height="100%" src="" frameborder="0" allowfullscreen=""></iframe>
    </div>
</div>
<script type="text/javascript" src="/js/course.js"></script>