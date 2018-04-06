<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Ad */

$this->title = Yii::t('app', 'Create Ad');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
