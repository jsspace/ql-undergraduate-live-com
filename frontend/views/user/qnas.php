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
        <p class="user-right-title">我的提问</p>
        <ul class="user-question-list">
            <?php foreach ($qlist as $key => $qu) {
                $course = Course::find()
                ->where(['id' => $qu->course_id])
                ->one();
                //$qu->check 0 待审核 1 审核通过 2 审核未通过
            ?>
                <li quas-status='<?= $qu->check ?>'>
                    <span class="course-img"><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"><img src="<?= $course->list_pic ?>"/></a></span>
                    <div class="question-content">
                        <p class="question-answer">
                            <span class="question-icon">问</span>
                            <span class="question-txt"><?= $qu->question ?></span>
                            <span class="question-date"><?= date('Y-m-d H:m:s', $qu->question_time) ?></span>
                        </p>
                        <p class="question-answer">
                            <span class="question-icon">答</span>
                            <span class="question-txt"><?= $qu->answer ?></span>
                            <span><?= date('Y-m-d H:m:s', $qu->answer_time) ?></span>
                        </p>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>