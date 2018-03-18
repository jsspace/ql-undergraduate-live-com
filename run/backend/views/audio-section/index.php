<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Audio;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AudioSectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Audio Sections');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audio-section-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Audio Section'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            //'id',
            'audio_name',
            'audio_author',
            'audio_url:url',
            [
                'attribute' => 'audio_id',
                'value'=> function ($model) {
                    return Audio::item($model->audio_id);
                },
                'filter'=>Audio::items(),
            ],
            'click_time:datetime',
            'collection',
            'share',
            'create_time:datetime',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
