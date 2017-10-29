<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Quas */

$this->title = Yii::t('app', 'Create Quas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Quas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
