<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/data.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span>资料下载</span>
</div>
<div class="data-wrapper">
    <ul class="data-inner">
        <?php foreach ($dataList as $key => $course_data) { ?>
            <li>
                <img class="course-data-img" src="<?= $course_data->list_pic ?>"/>
                <div class="right-con">
                    <p class="data-title">
                        <span class="data-label">考本必读</span>
                        <?php if ($course_data->url_type == 1) {
                            $url = Url::to(['data/detail', 'dataid' => $course_data->id]);
                            $target = '_self';
                        } else { 
                            $url = strip_tags($course_data->content);
                            $target = '_blank';
                        } ?>
                        <span><a target="<?= $target ?>" href="<?= $url ?>"><?= $course_data->name ?></a></span>
                    </p>
                    <p class="data-intro"><?= $course_data->summary ?></p>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>