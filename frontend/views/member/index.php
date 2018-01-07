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
    <?php 
        $str = '';
        foreach($member_items as $item) {
            $str .= '<div class="vip-section"><p class="vip-title">' . $item['course_category'] . '</p>';
            $str .= '<ul class="vip-list">';
            foreach($item['members'] as $member) {
                $str .= '<li data-id="' . $member->id . '">';
                $str .= '<em class="vip_tip-native">';
                $str .= '<i class="vip_tip-left"></i><i class="vip_tip-right"></i>';
                $str .= '<i class="vip_tip-center">' . $member->name . '</i>';
                $str .= '</em>';
                $str .= '<div class="vip-price">￥' . $member->discount . '</div>';
                $str .= '<div class="vip-date"><span>' . $member->time_period .'天</span></div>';
                $str .= '</li>';
            }
            $str .= '</ul>';
            $str .= '</div>';
        }
        echo $str;
    ?>

<?php $form = ActiveForm::begin(['action' => ['member/alipay'],'method'=>'post', 'id' => 'member_form']); ?>
<?= Html::hiddenInput('member_id'); ?>
<?= Html::hiddenInput('order_sn', $order_sn); ?>
<?= Html::submitButton('支付宝支付', ['class'=>'btn btn-primary ali_submit','name' =>'submit-button']) ?>
<?php ActiveForm::end(); ?>
<?php $form = ActiveForm::begin(['action' => ['member/wxpay'],'method'=>'post', 'id' => 'member_wx_form']); ?>
<?= Html::hiddenInput('member_id'); ?>
<?= Html::hiddenInput('order_sn', $order_sn); ?>
<?= Html::submitButton('微信支付', ['class'=>'btn btn-primary wx_submit','name' =>'submit-button']) ?>
<?php ActiveForm::end(); ?>


    </div>
</div>
<script>
var memberId = '';
$('.vip-section').each(function () {
    var $parentEle = $(this).find('.vip-list');
    $parentEle.find('li').on('click', function () {
        if ($(this).hasClass('havabuy')) {
            alert('您已经购买过此会员！')
        } else {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $(this).addClass('active').siblings('li').removeClass('active');
            }
        }
    });
});
$('button[name="submit-button"]').on('click', function (e) {
    e.preventDefault();
    $('.vip-list li').each(function () {
        if ($(this).hasClass('active')) {
            if (!memberId) {
                memberId = memberId + $(this).attr('data-id');
            } else {
                memberId = memberId + ',' + $(this).attr('data-id');
            }
        }
    });
    if (!memberId) {
        alert('请选择所需开通的会员');
        return false;
    }
    $(this).parents('form').find('input[name="member_id"]').val(memberId);
    $(this).parents('form').submit();
})
</script>

