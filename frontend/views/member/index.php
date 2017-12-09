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
                $str .= '<i class="vip_tip-center">' . $item['course_category'] . '</i>';
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
                <p class="vip-method"><img src="/img/vip-pay-method.png"/></p>
            </div>
        </div>
    </div>
</div>
<script>
$('.vip-list li').on('click', function(){
	$('.vip-list li').removeClass('active');
	$(this).addClass('active');
	$('#member_form input[name="member_id"]').val($(this).attr('data-id'));
});
</script>

