<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseChapter */
AppAsset::addCss($this,'@web/css/chapter_section.css');
?>
<div class="course-chapter-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'position',
        ],
    ]) ?>
</div>
