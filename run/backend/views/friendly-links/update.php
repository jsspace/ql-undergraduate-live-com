<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FriendlyLinks */

$this->title = '编辑友情链接';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Friendly Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="friendly-links-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
