<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;
use backend\models\CoursePackage;

AppAsset::addCss($this,'@web/css/package.css');

$this->title = $packageDetail['package']->name;

$package = $packageDetail['package'];
$courses = $packageDetail['course'];
?>
<input class="package-id _package-id" type="hidden" value="<?= $package->id; ?>"/>
<div class="package-detail-section">
    <div class="top-package">
        <div class="package-inner">
            <div class="left-package">
                <div class="img-package">
                    <img src="<?= $package->home_pic; ?>"/>
                </div>
                <div class="package-mask">
                    <!-- <p class="title"><?= $package->name ?></p> -->
                    <div class="package-list">
                        <p class="package-icon"><img src="/img/package-icon.png"/></p>
                        <p class="pack-t"><span class="num"><?= count($courses) ?></span>门课程</p>
                        <!-- <?php foreach ($courses as $course) { ?>
                             <p class="pack-con"><?= $course->course_name; ?></p>
                        <?php } ?> -->
                    </div>
                </div>
            </div>
            <div class="right-package">
                <p class="package-name"><?= $package->name ?><i><img src="/img/qrcode-img.png"/></i></p>
                <p class="package-icon-list">
                    <span><i class="icon ion-clock"></i> 30分钟</span>
                    <span><i class="icon ion-android-person"></i> <?= $package->online ?>人</span>
                    <span><i class="icon ion-document-text"></i> <?= date("Y-m-d", $package->create_time) ?></span>
                </p>
                <p class="package-detail"><?= $package->intro ?></p>
                <p class="package-price">
                    <span class="price-tag">现价</span>
                    <span class="price-highlight"><?= $package->discount ?>元</span>
                    <span class="price-tag">原价</span> <?= $package->price ?>元
                </p>
                <?php
                    $isClassMember = CoursePackage::isClassMember($package->id);
                    /*是否为公开课程*/
                    if ($package->discount == 0) { ?>
                        <span class="package-ispay-tag">公开班级</span>
                    <?php }
                    /*是否已加入班级*/
                    elseif ($isClassMember == 1) { ?>
                        <span class="package-ispay-tag">已入学</span>
                    <?php } else { ?>
                        <a href="javascript:void(0)" class="package-btn btn-green quick-buy _quick-buy">立即购买</a>
                        <a href="javascript:void(0)" class="package-btn btn-red add-cart _add-cart">加入购物车</a>
                        <!-- <p class="tips-detail">加入会员免费学（已有<?= $package->online ?>名会员加入）</p> -->
                    <?php } ?>
            </div>
        </div>
    </div>
    <div class="bottom-package">
        <div class="package-inner">
            <div class="left-section">
                <ul class="title-list">
                    <li class="active">套餐介绍</li>
                    <li>套餐内容</li>
                </ul>
                <div class="con-list">
                    <div class="con-detail active"><?= $package->des ?></div>
                    <div class="con-detail">
                        <ul class="course-list">
                            <?php foreach ($courses as $course) { ?>
                                <li>
                                    <div class="show-section">
                                        <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>" class="course-img"><img src="<?= $course->list_pic ?>"/></a>
                                        <p class="course-title">
                                            <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"><span class="title"><?= $course->course_name ?></span></a>
                                            <span class="star">
                                                <i class="icon ion-ios-star"></i>   
                                                <i class="icon ion-ios-star-half"></i>  
                                                <i class="icon ion-ios-star-outline"></i>
                                            </span>
                                        </p>
                                        <p class="price">
                                            <span><span class="price-num">￥<?= $course->discount ?></span>元</span>
                                        </p>
                                    </div>
                                    <!-- <div class="hide-section">
                                        <div class="course-detail-list">
                                            <a href="" class="name">课时1：前端框架结构<i class="icon ion-ios-download-outline"></i></a>
                                            <span class="time">6:40<i class="icon ion-videocamera"></i></span>
                                        </div>
                                    </div> -->
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script src="<?= Url::to('@web/js/package-detail.js');?>"></script>