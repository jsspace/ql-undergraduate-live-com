<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;

AppAsset::addCss($this,'@web/css/course.css');

$this->title = 'My Yii Application';
?>
<div class="container-course menu-position">
    <span>您的位置：</span>
    <span><a href="/">首页</a></span>
    <span>&gt;</span>
    <span>套餐列表</span>
</div>
<?php 
    $cat = Yii::$app->request->get('cat');
    $subcat = Yii::$app->request->get('subcat');
?>
<div class="container-course course-section">
    <div class="course-category">
        <div class="category-title">分类&gt;&gt;</div>
        <ul class="category-li">
            <li class="<?php if($cat == '') echo 'active'; ?>">
                <a href="<?= Url::to(['package/list']) ?>">全部</a>
            </li>
            <?php
                foreach ($packageLists as $firCat) {
                    $fir_seccat = reset($firCat['child']);
                    $fir_seccat_id = 0;
                    if ($fir_seccat) {
                        $fir_seccat_id = $fir_seccat['submodel']->id;
                    }
                ?>
                    <li class="<?php if($firCat['firModel']->id == $cat) echo 'active'; ?>">
                        <a href="<?= Url::to(['package/list', 'cat' => $firCat['firModel']->id, 'subcat' => $fir_seccat_id]) ?>"><?= $firCat['firModel']->name; ?></a>
                    </li>
            <?php } ?>
        </ul>
    </div>
    <?php
        if ($cat!='') {
    ?>
    <div class="course-category">
        <div class="category-title">子分类&gt;&gt;</div>
        <?php
                foreach ($packageLists as $firCat) { ?>
                <?php if($cat == $firCat['firModel']->id) { ?>
                <ul class="category-li _category-li">
            <?php
                    foreach ($firCat['child'] as $secCat) {
            ?>
                        <li class="<?php if($secCat['submodel']->id == $subcat) echo "active"; ?>">
                            <a href="<?= Url::to(['package/list', 'cat' => $firCat['firModel']->id, 'subcat' => $secCat['submodel']->id]) ?>"><?= $secCat['submodel']->name; ?></a>
                        </li>
            <?php   } ?>
                </ul>
         <?php } } ?>
    </div>
    <?php } ?>
    <div class="course-content">
        <ul class="list">
            <?php foreach ($packageLists as $firCat) {
                    if ($cat == $firCat['firModel']->id || $cat == '') {
                        foreach ($firCat['child'] as $secCat) {
                            if ($secCat['submodel']->id == $subcat || $subcat == '') {
                                foreach ($secCat['package'] as $package) { ?>
                                <li>
                                    <a href="<?= Url::to(['package/detail', 'pid' => $package->id]) ?>">
                                        <div class="course-img">
                                            <img class="course-pic" src="<?= $package->list_pic ?>"/>
                                        </div>
                                        <p class="content-title"><?= $package->name ?></p>
                                    </a>
                                        <div class="course-statistic">
                                            <i class="icon ion-android-person"></i>
                                            <span class="people"><?= $package->online ?>人在学</span>
                                            <i class="icon ion-heart"></i>
                                            <span class="people"><?= $package->collection ?>人</span>
                                        </div>
                                        <div class="teacher-section">
                                            <img src="<?= User::getUserModel($package->head_teacher)->picture; ?>"/>
                                            <span class="teacher-name"><?= User::item($package->head_teacher); ?></span>
                                        </div>
                                </li>
                    <?php   } } ?>
                <?php } } ?>
            <?php } ?>
        </ul>
    </div>
</div>
<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script>
    function imgAnimate() {
      var self = this;
      $(".course-content").each(function() {
          $(this).find("li").each(function() {
              $(this).find(".course-img").on("mouseover", function() {
                  $(this).addClass("active").parents("li").siblings("li").find(".course-img").removeClass("active");
              });
              $(this).find(".course-img").on("mouseout", function() {
                  $(this).removeClass("active");
              });
          });
      });
    }
    imgAnimate();
</script>