<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>

<div class="htcontent">
    <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">个人资料</a></h2>
    <div class="htbox2">
        <div class="httxt1 cc">
            <div class="user-update">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>