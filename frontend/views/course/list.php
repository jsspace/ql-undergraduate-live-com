<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use yii\widgets\LinkPager;

AppAsset::addCss($this,'@web/css/main.css');

$this->title = '热门班级';
?>
<div class="main cc" >
    <div class="nytxt1 cc">
        <?php foreach ($courses as $course) {
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
        <dl>
            <dt><img src="<?= $course->list_pic; ?>" width="383" height="285" /></dt>
            <dd>
                <h4><?= $course->course_name; ?></h4>
                <p class="bjms"><?= $course->intro; ?></p>
                <div class="tyny">
                    <p><img src="/images/nyicon1.png" />视频（<?= $classrooms ?>）讲</p>
                    <p><img src="/images/nyicon1a.png" />作业（<?= $homeworks ?>）次</p>
                    <p><img src="/images/unit-test-icon.png" />测试（<?= $unit_test ?>）次</p>
                    <!-- <p><img src="/images/mock-exam.png" />模拟考（<?= $course->examination_time; ?>）</p> -->
                    <h5>
                        <span class="colorfff">
                            <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>">进入学习</a>
                        </span>
                        课程已更新至<?= $classrooms ?>讲
                    </h5>
                </div>
            </dd>
        </dl>
        <?php } ?>
    </div>
    <div class="pagination-wrap">
        <?php 
            echo LinkPager::widget([
                'pagination' => $pages,
                'firstPageLabel'=>"首页",
                'lastPageLabel'=>'尾页',
            ]);
        ?>
    </div>
</div>
