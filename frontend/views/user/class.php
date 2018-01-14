<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/user.css');
AppAsset::addCss($this,'@web/css/vip.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
    </div>
</div>
<div class="user-wrapper site-vip">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <p class="user-right-title">我的班级会员</p>
        <?php foreach ($course_package_arr as $course_category => $course_package_models) {?>
        <div class="vip-section">
            <p class="vip-title"><?= $course_category ?></p>
            <ul class="college-class">
            <?php foreach ($course_package_models as  $course_package_model) {?>
                <li>
                    <p class="class-img"><img src="<?= Url::to('@web'.$course_package_model->list_pic) ?>"/></p>
                    <div class="vip-detail">
                        <p class="class-name"><?= $course_package_model->name ?></p>
                        <a href="<?= Url::to(['package/detail', 'pid' => $course_package_model->id]); ?>" class="class-btn">查看详情</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: <?= $course_package_model->discount ?>元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
                <?php }?>
            </ul>
        </div>
        <?php }?>
    </div>
</div>