<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AudioCategory */

$this->title = Yii::t('app', 'Create Audio Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audio Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audio-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
