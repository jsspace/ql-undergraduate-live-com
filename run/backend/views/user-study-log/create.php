<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserStudyLog */

$this->title = Yii::t('app', 'Create User Study Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Study Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-study-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
