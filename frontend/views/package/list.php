<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\CoursePackage;

AppAsset::addCss($this,'@web/css/package-list.css');

$this->title = '套餐';

?>
<div class="container-package">
    <ul>
        <?php foreach ($packageLists as $course) { ?>
            <li>
                <a href="<?= Url::to(['package/detail', 'pid' => $course->id]) ?>">
                    <div class="course-img">
                        <div class="bg"></div>
                        <img class="course-pic" src="<?= $course->list_pic; ?>"/>
                    </div>
                    <div class="course-name-time">
                        <span class="content-title"><?= $course->name; ?></span>
                        <!-- <span class="course-time"><?= date('Y-m-d H:i', $course->create_time); ?></span> -->
                    </div>
                </a>
                <div class="price-online">
                    <span class="price">￥<?= $course->discount; ?>元</span>
                    <span class="online"><?= $course->online; ?></span>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>