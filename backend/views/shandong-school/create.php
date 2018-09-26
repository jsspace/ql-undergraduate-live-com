<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ShandongSchool */

$this->title = Yii::t('app', 'Create Shandong School');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shandong Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shandong-school-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
