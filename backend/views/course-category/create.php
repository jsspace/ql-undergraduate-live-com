<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourseCategory */

$this->title = Yii::t('app', '新建课程分类');
?>
<div class="course-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
