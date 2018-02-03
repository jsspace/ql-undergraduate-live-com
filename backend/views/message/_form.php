<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\Lookup;
use backend\models\User;
use backend\models\CoursePackage;
use backend\assets\AppAsset;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\Message */
/* @var $form yii\widgets\ActiveForm */

AppAsset::addCss($this,'@web/css/message.css');

?>

<div class="message-form">
    
    <input class="classids" type="hidden" value="<?= $model->classids ?>">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => [
            'filebrowserUploadUrl' => Url::to(['course/uploadimg'], true)
        ],
    ]) ?>

    <?= $form->field($model, 'classids')->checkboxList(CoursePackage::items(),['item'=>function($index, $label, $name, $checked, $value){
        $checkStr = $checked ? "checked" : "";
        if ($value === 'alluser') {
            $classname = 'alluser all classitem';
        } else if ($value === 'allclass') {
            $classname = 'allclass item all';
        } else {
            $classname = 'item classitem';
        }
        return '<label><input type="checkbox" name="'.$name.'" value="'.$value.'" '.$checkStr.' class="'.$classname.'">'.$label.'</label>';
    }]); ?>

    <!-- <?php
        $isadmin = User::isAdmin(Yii::$app->user->id);
        if($isadmin === 1) {
            echo $form->field($model, 'status')->dropDownList(Lookup::items('message_status'));
        }
    ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript" src="/js/message.js"></script>