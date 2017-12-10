<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'order_status')->textInput() ?>

    <?= $form->field($model, 'pay_status')->textInput() ?>

    <?= $form->field($model, 'consignee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_id')->textInput() ?>

    <?= $form->field($model, 'pay_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_paid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'integral')->textInput() ?>

    <?= $form->field($model, 'integral_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bonus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'add_time')->textInput() ?>

    <?= $form->field($model, 'confirm_time')->textInput() ?>

    <?= $form->field($model, 'pay_time')->textInput() ?>

    <?= $form->field($model, 'bonus_id')->textInput() ?>

    <?= $form->field($model, 'is_separate')->textInput() ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invalid_time')->textInput() ?>

    <?= $form->field($model, 'course_ids')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coupon_ids')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coupon_money')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
