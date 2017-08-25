<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourseChapter */

$this->title = Yii::t('app', 'Create Course Chapter');
?>
<div class="course-chapter-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
