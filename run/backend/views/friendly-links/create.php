<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FriendlyLinks */

$this->title = Yii::t('app', '新建友情链接');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Friendly Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="friendly-links-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
