<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseChapter */

$this->title = Yii::t('app', '编辑');
?>
<div class="course-chapter-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
