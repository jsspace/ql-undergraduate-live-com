<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Notice */

$this->title = Yii::t('app', 'Create Notice');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
