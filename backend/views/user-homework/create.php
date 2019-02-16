<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserHomework */

$this->title = Yii::t('app', 'Create User Homework');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Homeworks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-homework-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
