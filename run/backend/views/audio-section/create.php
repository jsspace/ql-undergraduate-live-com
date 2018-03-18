<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AudioSection */

$this->title = Yii::t('app', 'Create Audio Section');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audio Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audio-section-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
