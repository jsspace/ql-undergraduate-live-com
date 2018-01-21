<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use backend\models\Provinces;
use backend\models\Cities;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'provinceid')->dropDownlist(Provinces::items(),[
            'prompt' => '- 请选择省份 -',
            'onchange'=>'getCitys(this.value)'
    ]) ?>
    <?= $form->field($model, 'cityid')->dropDownList(Cities::items($model->provinceid), ['prompt'=>'- 请选择地级市 -']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
    <?php 
    $roles = Yii::$app->authManager->getAssignments(Yii::$app->user->id);
    if (isset($roles['admin'])) {
        echo $form->field($model, 'percentage')->textInput();
    }
    ?>

    <?php // $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'status')->textInput() ?>

    <?php // $form->field($model, 'created_at')->textInput() ?>

    <?php // $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'gender')->dropDownList([0 => '男', 1 => '女']) ?>

    <?= $form->field($model, 'picture')->widget(FileInput::classname(),
        [
            'options' => ['accept' => 'image/png,image/jpeg'],
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
                'initialPreview' => [
                    $model->picture ? Html::img("/".$model->picture, $options = ['width' => '100px']) : null,
                ]
            ],
        ]) ?>
    <p class="hint picture-hint">（请上传220x220尺寸的图片）</p>    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript" src="/js/user.js"></script>