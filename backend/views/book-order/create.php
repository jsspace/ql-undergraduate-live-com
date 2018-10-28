<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BookOrder */

$this->title = Yii::t('app', 'Create Book Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Book Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
