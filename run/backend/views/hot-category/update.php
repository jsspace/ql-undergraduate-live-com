<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HotCategory */

$this->title = '编辑热门分类';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hot Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="hot-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
