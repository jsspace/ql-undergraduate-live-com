<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Withdraw */

$this->title = '修改提现信息';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Withdraws'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->withdraw_id, 'url' => ['view', 'id' => $model->withdraw_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="withdraw-update">

    <?= $this->render('_form', [
        'model' => $model,
        'marketer' => $marketer,
    ]) ?>

</div>
