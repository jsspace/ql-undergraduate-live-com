<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Quas */

$this->title = '回答问题';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Quas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quas-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
