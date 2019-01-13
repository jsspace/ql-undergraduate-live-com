<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\widgets\LinkPager;

AppAsset::addCss($this,'@web/css/book.css');

$this->title = '应考必备';
?>
<div class="book-content">
    <ul class="list">
        <?php foreach ($books as $book) { ?>
            <li>
                <a href="<?= Url::to(['book/detail', 'bookid' => $book->id]) ?>">
                    <img src="<?= $book->pictrue ?>">
                    <p class="book-name"><?=$book->name ?></p>
                    <p class="price-wrap">
                        <span class="order-price">￥<?=$book->order_price ?></span>
                        <span class="price">￥<?=$book->price ?></span>
                    </p>
                </a>
            </li>
        <?php } ?>
    </ul>
    <div class="clear"></div>
    <?php 
        echo LinkPager::widget([
            'pagination' => $pages,
            'firstPageLabel'=>"首页",
            'lastPageLabel'=>'尾页',
        ]);
    ?>
</div>
