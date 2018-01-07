<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Command */

$this->title = Yii::t('app', 'Create Command');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="command-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
