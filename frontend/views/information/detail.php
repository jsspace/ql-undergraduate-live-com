<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/timetable.css');
$this->title = iconv('GBK', 'UTF-8', 'Éý±¾×ÊÑ¶');

?>

<div class="htcontent">
        <div class="htbox2">
            <div class="about-content">
                <h1><?=$information->title?></h1>
                <p class="sub-title">
                    <?=iconv('GBK', 'UTF-8', 'À´Ô´£º') ?><?=$information->author ?>
                    &nbsp; &nbsp;  | &nbsp; &nbsp;
                    <?=iconv('GBK', 'UTF-8', '·¢²¼Ê±¼ä£º') ?><?=$information->release_time ?>
                </p>

                <?=$information->content ?>
            </div>
        </div>
    </div>

</body>
</html>