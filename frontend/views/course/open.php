<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use yii\widgets\LinkPager;
use backend\models\Course;

AppAsset::addCss($this,'@web/css/list.css');

$this->title = '公开课';
?>
<input class="is_guest" type="hidden" value="<?= Yii::$app->user->isGuest; ?>"/>
<div class="container-course course-online">
    <div class="container-course-wrap">
        <div class="course-content">
            <ul class="list">
                <?php foreach ($courses as $course) { ?>
                    <li>
                        <a href="javascript: void(0)">
                            <div class="course-img">
                                <div class="bg"></div>
                                <?php
                                $ispay = Course::ispay($course->id, Yii::$app->user->id);
                                if ($course->discount == 0 || $ispay == 1) { ?>
                                    <span class="video-play-btn" data-value="<?= $course->id ?>"></span>
                                <?php } else { ?>
                                    <span class="quick-buy _quick-buy" data-value="<?= $course->id ?>"></span>
                                <?php } ?>
                                <img class="course-pic" src="<?= $course->list_pic; ?>"/>
                            </div>
                            <span class="content-title"><?= $course->course_name; ?></span>
                            <span class="course-time"><?= date('Y-m-d H:i', $course->create_time); ?></span>
                        </a>
                        <div class="teacher-section">
                            <!-- <img src="<?= User::getUserModel($course->teacher_id)->picture; ?>"/> -->
                            <span class="teacher-name">主讲人：<?= User::item($course->teacher_id); ?></span>
                            <span class="course-price">价格：<?= $course->discount; ?>元</span>
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
        <!-- <iframe width="100%" height="100%" src="" frameborder="0" allowfullscreen=""></iframe> -->
        <video id="course-video" width="100%" height="100%" controls="controls"></video>
    </div>
</div>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script type="text/javascript" src="/js/course.js"></script>