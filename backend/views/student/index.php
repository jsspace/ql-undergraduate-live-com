<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
use backend\models\Provinces;
use backend\models\Cities;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '学员列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '创建学员'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            [
                'attribute' => 'gender',
                'value'=> function ($model) {
                    return $model->gender == 1 ? '女':'男';
                },
                'filter' => [1=>'女',0=>'男' ],
            ],
//             'auth_key',
//             'password_hash',
//             'password_reset_token',
            // 'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',
            'phone',
            [
                'attribute' => 'provinceid',
                'value' => function ($data) {
                return Provinces::item($data->provinceid);
                },
                'filter'=>Provinces::items(),
            ],
            [
                'attribute' => 'cityid',
                'value' => function ($data) {
                    return Cities::item($data->cityid);
                },
                'filter'=>Cities::items($searchModel->provinceid),
            ],
            // 'description',
            // 'unit',
            // 'office',
            // 'goodat',
            // 'picture',
            // 'intro:ntext',
            [
                'attribute' => 'invite',
                'value'=> function ($model) {
                    return User::item($model->invite);;
                },
                'filter' => User::getAllUsers(),
            ],
            // 'wechat',
            // 'wechat_img',
            // 'percentage',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
