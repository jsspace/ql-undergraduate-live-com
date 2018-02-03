<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Provinces;
use backend\models\Cities;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'picture')->widget(FileInput::classname(),
        [
            'options' => ['accept' => 'image/png,image/jpeg'],
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
                'initialPreview' => [
                    $model->picture ? Html::img('/'.$model->picture, $options = ['width' => '170px']) : null,
                ]
            ],
        ]) ?>

    <?= $form->field($model, 'provinceid')->dropDownlist(Provinces::items(),[
            'prompt' => '- 请选择省份 -',
            'onchange'=>'getCitys(this.value)'
    ]) ?>
    <?= $form->field($model, 'cityid')->dropDownList(Cities::items($model->provinceid), ['prompt'=>'- 请选择地级市 -']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript" src="/js/user.js"></script>