<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookOrder */

$this->title = Yii::t('app', 'Update Book Order', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Book Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="book-order-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
