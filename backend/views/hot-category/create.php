<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HotCategory */

$this->title = Yii::t('app', 'Create Hot Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hot Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hot-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
