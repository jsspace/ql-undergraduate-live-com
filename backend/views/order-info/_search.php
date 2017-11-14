<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_sn') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'order_status') ?>

    <?= $form->field($model, 'pay_status') ?>

    <?php // echo $form->field($model, 'consignee') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'pay_id') ?>

    <?php // echo $form->field($model, 'pay_name') ?>

    <?php // echo $form->field($model, 'goods_amount') ?>

    <?php // echo $form->field($model, 'pay_fee') ?>

    <?php // echo $form->field($model, 'money_paid') ?>

    <?php // echo $form->field($model, 'integral') ?>

    <?php // echo $form->field($model, 'integral_money') ?>

    <?php // echo $form->field($model, 'bonus') ?>

    <?php // echo $form->field($model, 'order_amount') ?>

    <?php // echo $form->field($model, 'add_time') ?>

    <?php // echo $form->field($model, 'confirm_time') ?>

    <?php // echo $form->field($model, 'pay_time') ?>

    <?php // echo $form->field($model, 'bonus_id') ?>

    <?php // echo $form->field($model, 'is_separate') ?>

    <?php // echo $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'invalid_time') ?>

    <?php // echo $form->field($model, 'course_ids') ?>

    <?php // echo $form->field($model, 'coupon_ids') ?>

    <?php // echo $form->field($model, 'coupon_money') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
