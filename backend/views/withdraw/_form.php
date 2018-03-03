<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Withdraw */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->dropDownList(['student' => '教师', 'marketer' => '市场专员'], ['prompt' => '请选择...']) ?>

    <?= $form->field($model, 'user_id')->dropDownList($marketer) ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'withdraw_date')->textInput() ?>

    <?= $form->field($model, 'bankc_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([0 => '未提现', 1 => '已提现'], ['prompt' => '请选择...']) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
