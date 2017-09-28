<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Data */

$this->title = Yii::t('app', 'Create Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
