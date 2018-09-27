<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use backend\models\Provinces;
use backend\models\Cities;
use backend\models\ShandongSchool;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<style type="text/css">
    .upload-picture {
        width: 80px;
        height: 80px;
        font-size: 14px;
        border-radius: 4px;
        line-height: 80px;
        color: #fff;
        position: absolute;
        text-align: center;
        background-color: rgba(0,0,0,0.3);
    }
    .upload-picture input {
        background: transparent;
        border: none;
        margin: 0;
        outline: none;
        padding: 0;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        opacity: 0;
        height: 80px;
    }
    a.upload-picture:active,
    a.upload-picture:hover,
    a.upload-picture:link,
    a.upload-picture:visited {
        color: #fff;
    }
    .upload-picture label {
        display: none;
    }
    .picture-hint {
        margin-bottom: 10px;
    }
    .picture-wrap {
        margin-bottom: 15px;
    }
    .picture-wrap img {
        width: 80px;
        height: 80px;
        display: inline-block;
        border-radius: 4px;
    }
    .user-form label {
        width: 30px;
    }
</style>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="picture-wrap">
        <p class="hint picture-hint">请上传220x220尺寸的图片</p>
        <a href="javascript:void(0);" class="upload-picture">
            上传头像
            <?= $form->field($model, 'picture')->fileInput() ?>
        </a>
        <img class="avatar-img" src="<?= $model->picture ? $model->picture : '/img/avatar.png' ?>">
    </div>
    
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?> -->
	<?php if(Yii::$app->controller->action->id !== 'edit') {?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
	<?php }?>

    <?= $form->field($model, 'gender')->dropDownList(['1'=>'女', '0'=>'男']) ?>

    <?= $form->field($model, 'cityid')->dropDownList(Cities::items('370000'), [
            'prompt' => '- 请选择地区 -',
            'onchange'=>'getSchools(this.value)'
    ]) ?>

    <?= $form->field($model, 'schoolid')->dropDownList(ShandongSchool::schools($model->cityid), [
        'prompt' => '- 请选择学校 -',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript" src="/js/user.js"></script>