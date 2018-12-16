<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourseSection */

$this->title = Yii::t('app', 'Create Course Section');

?>
<div class="course-section-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
