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
<?php $form = ActiveForm::begin(['action' => ['member/pay'],'method'=>'post', 'id' => 'member_form']); ?>
<?= Html::hiddenInput('member_id', 1); ?>
<?= Html::hiddenInput('order_sn', $order_sn); ?>
<?= Html::submitButton('支付宝支付', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>

<?php ActiveForm::end(); ?>
    </div>
</div>
<script>
var memberId = '';
$('.vip-section').each(function () {
    var $parentEle = $(this).find('.vip-list');
    $parentEle.find('li').on('click', function () {
        $(this).addClass('active').siblings('li').removeClass('active');
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
    $('#member_form input[name="member_id"]').val(memberId);
    $('#member_form').submit();
})
</script>

