<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use yii\widgets\LinkPager;

AppAsset::addCss($this,'@web/css/main.css');

$this->title = '新课提醒';
?>
<div class="main cc" >
    <div class="nytxt1 cc">
        <?php foreach ($courses as $course) {
            $sections = $course->courseSections;
        ?>
        <dl>
            <dt><img src="<?= $course->list_pic; ?>" width="383" height="285" /></dt>
            <dd>
                <h4><?= $course->course_name; ?></h4>
                <p class="bjms"><?= $course->intro; ?></p>
                <div class="tyny">
                    <p><img src="/images/nyicon1.png" />课堂学（<?= count($sections) ?>）</p>
                    <p><img src="/images/nyicon1a.png" />随堂练（<?= count($sections) ?>）</p>
                    <p><img src="/images/nyicon1b.png" />问老师</p>
                    <p><img src="/images/nyicon1.png" />模拟考（<?= $course->examination_time; ?>）</p>
                    <h5><span class="colorfff"><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>">体验一下</a></span><?= $course->online; ?>人正在学习</h5>
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
