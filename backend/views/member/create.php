<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Member */

$this->title = Yii::t('app', 'Create Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'course_category' => $course_category,
    ]) ?>

</div>
