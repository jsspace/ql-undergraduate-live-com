<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
AppAsset::addCss($this,'@web/css/main.css');
AppAsset::addCss($this,'@web/css/course.css');
AppAsset::addCss($this,'@web/css/book-detail.css');

$this->title = '图书详情';

?>
<input class="book-id" type="hidden" value="<?= $book->id; ?>"/>
<input class="is-guest" type="hidden" value="<?= Yii::$app->user->isGuest; ?>"/>
<div class="main cc" style="padding:35px 0;">
    <dl class="nytxt2">
        <dt>
            <img src="<?= $book->pictrue ?>">
        </dt>
        <dd>
            <h4 class="book-name"><?= $book->name ?></h4>
            <p><?= $book->intro ?></p>
            <div class="price-wrap">
                <span class="order-price">￥<?=$book->order_price ?></span>
                <span class="price">￥<?=$book->price ?></span>
            </div>
            <div class="order-book">
                <!-- <input type="text" name="" class="order-book-num" placeholder="预定本数" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" value="1">本 -->
                <input type="hidden" name="" class="order-book-num" placeholder="预定本数" value="1">
                <span class="order-book-btn">我要预定</span>
            </div>
        </dd>
    </dl>
    <div class="nytxt3 cc">
        <div class="nytxt3_l">
            <div class="nytxt3_lny1">
                <dl class="cc course-tag">
                    <dd><a href="javascript: void(0)">课程介绍</a></dd>
                </dl>
            </div>
            <div class="course-tag-content">
                <div class="tag-content">
                    <?= $book->des; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script src="<?= Url::to('@web/js/book-detail.js');?>"></script>