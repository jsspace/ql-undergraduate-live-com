<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */

$this->title = Yii::t('app', 'Create Lookup');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lookups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
