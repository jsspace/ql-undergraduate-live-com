<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
use backend\models\CourseComent;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Comment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            //'id',
            [
                'attribute' => 'user_id',
                'value'=> function ($model) {
                    return User::item($model->user_id);
                },
                'filter' => User::users('student'),
            ],
            'content:ntext',
            [
                'attribute' => 'check',
                'value'=> function ($model) {
                    return CourseComent::item($model->check);
                },
                'filter' => CourseComent::items(),
            ],
            'create_time:datetime',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
