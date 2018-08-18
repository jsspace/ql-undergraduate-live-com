<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\User;

$this->title = '我的收藏';
?>
<div class="htcontent">
    <h2 class="htwx cc"><a href="/">首页</a>&gt;<a href="#">我的收藏</a></h2>
    <div class="htbox2">
        <div class="httxt1 cc">
            <h3 class="ht_tt1">我的收藏</h3>
            <ul class="user-course-list">
                <?php foreach ($flist as $key => $course) { ?>
                <li>
                    <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"
                       class="user-course-img"><img src="<?= $course->list_pic ?>"/></a>
                    <div class="user-course-details">
                        <h3><a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>"
                               title="<?= $course->course_name ?>" target="_blank"><?= $course->course_name ?></a>
                        </h3>
                        <div class="row">主讲老师: <?= User::item($course->teacher_id); ?></div>
                        <div class="row">
                            <div class="btns">
                                <input type="hidden" name="" value="<?= $course->id ?>">
                                <a class="btn btn-primary _quick-buy" target="_blank" href="javascript:void(0);">立即购买</a>
                                <input class="course-id _course-id" type="hidden" value="<?= $course->id; ?>"/>
                                <a class="btn btn-default unfavorite _unfavorite" href="javascript:void(0);"
                                   data-id="<?= $course->id ?>" data-favor="1">取消收藏</a>
                            </div>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <?php if (count($flist) == 0) { ?>
            <div class="empty-content">您还没有收藏任何课程哦~赶紧去 <a href="/course/list" class="go-link">挑选课程&gt;&gt;</a></div>
            <?php } ?>
        </div>
    </div>
</div>
<script src="<?= Url::to('@web/js/course-detail.js');?>"></script>
<script type="text/javascript">
    $('._unfavorite').on('click', function() {
        var self = this;
        var course_id = $(this).attr('data-id');
        var favor = $(this).attr('data-favor');
        $.ajax({
            url: '/user/unfavorite',
            type: 'post',
            data: {
                'course_id': course_id,
                'favor': favor,
                '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
            },
            success: function (data) {
                if (favor == "1") {
                    $(self).html('收藏');
                    $(self).attr('data-favor', 0);
                } else {
                    $(self).html('取消收藏');
                    $(self).attr('data-favor', 1);
                }
            }
        });
    });
</script>
