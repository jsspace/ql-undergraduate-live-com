<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/vip.css');

$this->title = '购买vip会员';
?>
<div class="site-vip">
    <div class="inner">
        <div class="vip-section">
            <p class="vip-title">健康会员</p>
            <ul class="vip-list">
                <li class="active">
                    <em class="vip_tip-native">
                        <i class="vip_tip-left"></i>
                        <i class="vip_tip-right"></i>
                        <i class="vip_tip-center">健康会员</i>
                    </em>
                    <div class="vip-price">￥199</div>
                    <div class="vip-date"><span>30天</span></div>
                </li>
                <li>
                    <em class="vip_tip-native">
                        <i class="vip_tip-left"></i>
                        <i class="vip_tip-right"></i>
                        <i class="vip_tip-center">健康会员</i>
                    </em>
                    <div class="vip-price">￥199</div>
                    <div class="vip-date"><span>30天</span></div>
                </li>
                <li>
                    <em class="vip_tip-native">
                        <i class="vip_tip-left"></i>
                        <i class="vip_tip-right"></i>
                        <i class="vip_tip-center">健康会员</i>
                    </em>
                    <div class="vip-price">￥199</div>
                    <div class="vip-date"><span>30天</span></div>
                </li>
                <li>
                    <em class="vip_tip-native">
                        <i class="vip_tip-left"></i>
                        <i class="vip_tip-right"></i>
                        <i class="vip_tip-center">健康会员</i>
                    </em>
                    <div class="vip-price">￥199</div>
                    <div class="vip-date"><span>30天</span></div>
                </li>
                <li>
                    <em class="vip_tip-native">
                        <i class="vip_tip-left"></i>
                        <i class="vip_tip-right"></i>
                        <i class="vip_tip-center">健康会员</i>
                    </em>
                    <div class="vip-price">￥199</div>
                    <div class="vip-date"><span>30天</span></div>
                </li>
            </ul>
        </div>
        <div class="vip-section">
            <p class="vip-title">书画会员</p>
            <ul class="vip-list">
                <li>
                    <em class="vip_tip-native">
                        <i class="vip_tip-left"></i>
                        <i class="vip_tip-right"></i>
                        <i class="vip_tip-center">书画会员</i>
                    </em>
                    <div class="vip-price">￥199</div>
                    <div class="vip-date"><span>30天</span></div>
                </li>
            </ul>
        </div>
        <div class="vip-section">
            <p class="vip-title">音乐会员</p>
            <ul class="vip-list">
                <li>
                    <em class="vip_tip-native">
                        <i class="vip_tip-left"></i>
                        <i class="vip_tip-right"></i>
                        <i class="vip_tip-center">书画会员</i>
                    </em>
                    <div class="vip-price">￥199</div>
                    <div class="vip-date"><span>30天</span></div>
                </li>
                <li>
                    <em class="vip_tip-native">
                        <i class="vip_tip-left"></i>
                        <i class="vip_tip-right"></i>
                        <i class="vip_tip-center">音乐会员</i>
                    </em>
                    <div class="vip-price">￥199</div>
                    <div class="vip-date"><span>30天</span></div>
                </li>
            </ul>
        </div>
        <div class="vip-pay">
            <div class="vip-left">
                <p class="pay-code">
                    <img src="/img/vip-qrcode.png" data-vippay-widget="codeImg" width="92" height="92">
                    <span class="pay-code-bg">
                        <i></i>
                        <span>请点击刷新</span>
                    </span>
                </p>
            </div>
            <div class="vip-right">
                <p class="total-price">199元</p>
                <p class="vip-tip">请使用支付宝支付</p>
            </div>
        </div>
    </div>
</div>
