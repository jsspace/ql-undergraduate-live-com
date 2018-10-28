<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Book */

$this->title = Yii::t('app', 'Create Book');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">

    <?= $this->render('_form', [
        'model' => $model,
        'categorys' => $categorys
    ]) ?>

</div>
