<?php
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Information;
use yii\widgets\LinkPager;

AppAsset::addCss($this,'@web/css/information.css');

$this->title = iconv('GBK', 'UTF-8', '升本资讯');
?>

<div class="main cc">
    <div class="content">
       <ul>
           <?php foreach ($informations as $information) { ?>
               <li>
                   <div class="left"><img class="content_pic" src=<?=$information->cover_pic ?> alt=""></div>
                   <div class="right">
                       <div class="right_top">
                           <a href="/information/detail?information_id=<?=$information->id ?>"><h3><?=$information->title ?></h3></a>
                       </div>
                       <div class="content_content">
                           <?=$information->content?>
                       </div>
                       <div class="right_bottom">
                           <div class="right_bottom_left">
                               <span><?=iconv('GBK', 'UTF-8', '来源：') ?><?=$information->author ?></span>
                               <span>   |   </span>
                               <span><?=iconv('GBK', 'UTF-8', '发布时间：') ?><?=$information->release_time ?></span>
                           </div>
                       </div>
                   </div>
               </li>
           <?php } ?>
       </ul>
    </div>
    <div class="pagination-wrap">
        <?php
        echo LinkPager::widget([
            'pagination' => $pages,
            'firstPageLabel'=>iconv('GBK', 'UTF-8', '首页'),
            'lastPageLabel'=>iconv('GBK', 'UTF-8', '尾页'),
        ]);
        ?>
    </div>
</div>
