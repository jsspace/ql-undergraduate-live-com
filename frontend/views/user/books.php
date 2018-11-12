<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Course;
use backend\models\OrderInfo;
use backend\models\OrderGoods;
/*use backend\models\CoursePackage;*/

$this->title = '我的图书预定';
?>
<style type="text/css">
    .book-content {
        padding: 30px 2%;
    }
    table {
        width: 80%;
    }
    .book-content tr {
        line-height: 30px;
        background-color: #f6f6f6;
    }
    .book-content th,
    .book-content td {
        border: 1px solid #ccc;
        padding-left: 5px;
    }
    .book-content h3 {
        height: 55px;
        line-height: 55px;
        background: #f0f3f9;
        text-indent: 2em;
        font-size: 16px;
        margin-bottom: 25px;
    }
</style>
<div class="htcontent">
    <h2 class="htwx cc"><a href="/">首页</a>&gt;<a href="#">我的图书预定</a></h2>
    <div class="book-content">
        <h3 class="ht_tt1">我的预定</h3>
        <table>
            <tr>
                <th>图书名</th>
                <th>图书数量</th>
                <th>操作</th>
            </tr>
            <?php foreach ($all_books as $book) { ?>
                <tr class="list">
                    <td>
                        <span><?= $book->book_name ?></span>
                    </td>
                    <td>
                       <span><?= $book->book_num ?></span>
                    </td>
                    <td>
                        <a href="<?= Url::to(['book/detail', 'bookid' => $book->bookid]) ?>">查看详情</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <div class="clear"></div>
    </div>
</div>
</body>
</html>
