<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/timetable.css');
$this->title = iconv('GBK', 'UTF-8', '������Ѷ');

?>

<div class="htcontent">
        <h2 style="font-size: 18px; background: gray; margin-top: 55px;"><a href="/information/list"><?=iconv('GBK', 'UTF-8', '������Ѷ') ?></a>&gt;<a href="#"><?=$information->title?></a></h2>
        <div class="htbox2">
            <div class="about-content">
                <h1><?=$information->title?></h1>
                <p class="sub-title">
                    <?=iconv('GBK', 'UTF-8', '��Դ��') ?><?=$information->author ?>
                    &nbsp; &nbsp;  | &nbsp; &nbsp;
                    <?=iconv('GBK', 'UTF-8', '����ʱ�䣺') ?><?=$information->release_time ?>
                </p>

                <?=$information->content ?>
            </div>
        </div>
    </div>

</body>
</html>