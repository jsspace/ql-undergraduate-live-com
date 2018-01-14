<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/vip.css');

$this->title = '购买vip会员';
?>
<div class="site-vip">
    <div class="inner">
        <div class="vip-section vip-tip">
            <p class="vip-title"><i class="icon ion-ios-navigate-outline"></i>入学须知</p>
            <div class="tip-con">
                <p>感谢您成为本校的学员，在办理学习会员前， 请认真阅读以下须知：</p>
                <p>1.请持《入学通知书》于2017年8月22日当天到我校报到注册并办理入学手续。</p>
                <p>2.新生正式报到时，学校将统一赠送一套卧具（被套、棉被、草席、枕芯、蚊帐、床单、枕套）和三年学生平安保险。</p>
                <p>3.新生来校报到时还应携带本人及监护人户口本及身份证复印件一式两份。</p>
            </div>
        </div>
        <div class="vip-section">
            <p class="vip-title">健康学院</p>
            <ul class="college-class">
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">办理入学</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">办理入学</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">办理入学</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
                <li>
                    <p class="class-img"><img src="../img/course-list-img.jpg"/></p>
                    <div class="vip-detail">
                        <p class="class-name">文学院初级班</p>
                        <a href="" class="class-btn">办理入学</a>
                        <p class="class-price"><i class="icon ion-ios-pricetags-outline"></i>价格: 200元</p>
                        <p class="class-date"><i class="icon ion-ios-timer-outline"></i>有效期: 360天</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>