<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;
use backend\models\Lookup;
use kartik\datetime\DateTimePicker; 

/* @var $this yii\web\View */
/* @var $model backend\models\OrderInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(User::getAllUsers()) ?>

    <?= $form->field($model, 'pay_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_name')->dropDownList(Lookup::items('pay_way')) ?>

    <?= $form->field($model, 'goods_amount')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'money_paid')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'order_amount')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'pay_time')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]);
    ?>
    <?= $form->field($model, 'invalid_time')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
