<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Course;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
</div>
<div class="user-wrapper">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <p class="user-right-title">课程评价</p>
        <ul class="user-evaluate">
            <?php foreach ($coments as $key => $coment) {
                $course = Course::find()
                ->where(['id' => $coment->course_id])
                ->one();
                //$coment->check 0 待审核 1 审核通过 2 审核未通过
            ?>
                <li evaluate-status="<?= $coment->check; ?>">
                    <div class="evaluate-left">
                        <p class="evaluate-img"><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"><img src="<?= $course->list_pic ?>"/></a></p>
                        <p class="evaluate-course-name"><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"><?= $course->course_name ?></a></p>
                    </div>
                    <div class="evaluate-right">
                        <div class="star">
                            <?php
                                for ($i=0; $i < $coment->star; $i++) { ?>
                                    <img src="/img/star-on.png">
                            <?php } ?>
                            <?php
                                for ($i=0; $i < 5-$coment->star; $i++) { ?>
                                    <img src="/img/star-off.png">
                            <?php } ?>
                        </div>
                        <div class="evaluate-content"><?= $coment->content ?></div>
                        <div class="evaluate-date"><?= date('Y-m-d H:m:s', $coment->create_time) ?></div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>