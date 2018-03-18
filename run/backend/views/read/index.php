<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="read-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a(Yii::t('app', 'Create Read'), ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'msg_id',
            [
                'attribute' => 'userid',
                'value'=> function ($model) {
                    return User::item($model->userid);
                }
            ],
            [
                'attribute' => 'status',
                'value'=> function ($model) {
                    return $model->status == 1 ? '已读':'未读';
                },
                'filter' => [1=>'已读',0=>'未读' ],
            ],
            'get_time:datetime',
            'read_time:datetime',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
