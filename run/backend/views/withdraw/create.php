<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Withdraw */

$this->title = Yii::t('app', 'Create Withdraw');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Withdraws'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user,
    ]) ?>

</div>
