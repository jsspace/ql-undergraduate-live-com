<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FriendlyLinks */

$this->title = '查看友情链接';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Friendly Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="friendly-links-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'src',
            'position',
        ],
    ]) ?>

</div>
