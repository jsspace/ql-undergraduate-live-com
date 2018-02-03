<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Provinces;
use backend\models\Cities;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SchoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '集体账户列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'label'=>'订单',
                'format'=>'raw',
                'value' => function($model){
                    $url = Url::to(['school/order', 'userid' => $model->id]);
                    return Html::a('查看订单', $url);
                }
            ],
            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'email:email',
            //'status',
            // 'created_at',
            // 'updated_at',
            'phone',
            // 'description',
            'unit',
            // 'office',
            // 'goodat',
            // 'picture',
            // 'intro:ntext',
            // 'invite',
            // 'wechat',
            // 'wechat_img',
            // 'percentage',
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
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
