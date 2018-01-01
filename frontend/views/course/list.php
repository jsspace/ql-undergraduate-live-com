<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\CourseCategory;

AppAsset::addCss($this,'@web/css/course.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span>课程列表</span>
    </div>
</div>
<?php 
    $cat = Yii::$app->request->get('cat');
    $subcat = Yii::$app->request->get('subcat');
?>
<div class="container-course course-section">
    <div class="course-category">
        <div class="container-inner">
            <div class="category-title">分类&gt;&gt;</div>
            <ul class="category-li">
                <li class="<?php if($cat == '') echo 'active'; ?>">
                    <a href="<?= Url::to(['course/list']) ?>">全部</a>
                </li>
                <?php
                    foreach ($courseLists as $firCat) {
                        $fir_seccat = reset($firCat['child']);
                        $fir_seccat_id = 0;
                        if ($fir_seccat) {
                            $fir_seccat_id = $fir_seccat['submodel']->id;
                        }
                    ?>
                        <li class="<?php if($firCat['firModel']->id == $cat) echo 'active'; ?>">
                            <a href="<?= Url::to(['course/list', 'cat' => $firCat['firModel']->id, 'subcat' => $fir_seccat_id]) ?>"><?= $firCat['firModel']->name; ?></a>
                        </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php
        if ($cat!='') {
    ?>
    <div class="course-category _course-category">
        <div class="container-inner">
        <div class="category-title">子分类&gt;&gt;</div>
            <?php
                foreach ($courseLists as $firCat) { ?>
                <?php if($cat == $firCat['firModel']->id) { ?>
                <ul class="category-li">
            <?php
                    foreach ($firCat['child'] as $secCat) {
            ?>
                        <li class="<?php if($secCat['submodel']->id == $subcat) echo "active"; ?>">
                            <a href="<?= Url::to(['course/list', 'cat' => $firCat['firModel']->id, 'subcat' => $secCat['submodel']->id]) ?>"><?= $secCat['submodel']->name; ?></a>
                        </li>
            <?php   } ?>
                </ul>
         <?php } } ?>
         </div>
    </div>
    <?php } ?>
    <div class="course-content">
        <div class="container-inner">
            <ul class="list">
                <?php foreach ($courseLists as $firCat) {
                        if ($cat == $firCat['firModel']->id || $cat == '') {
                            foreach ($firCat['child'] as $secCat) {
                                if ($secCat['submodel']->id == $subcat || $subcat == '') {
                                    foreach ($secCat['course'] as $course) { ?>
                                    <li>
                                        <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>">
                                            <div class="course-img">
                                                <img class="course-pic" src="<?= $course->list_pic ?>"/>
                                            </div>
                                            <p class="content-title"><?= $course->course_name ?></p>
                                        </a>
                                            <div class="course-statistic">
                                                <i class="icon ion-android-person"></i>
                                                <span class="people"><?= $course->online ?>人在学</span>
                                                <i class="icon ion-heart"></i>
                                                <span class="people"><?= $course->collection ?>人</span>
                                            </div>
                                            <div class="teacher-section">
                                                <img src="<?= User::getUserModel($course->teacher_id)->picture; ?>"/>
                                                <span class="teacher-name"><?= User::item($course->teacher_id); ?></span>
                                            </div>
                                    </li>
                        <?php   } } ?>
                    <?php } } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="/js/course-list.js"></script>