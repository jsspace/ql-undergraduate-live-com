<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
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
            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'value'=> function ($model) {
                    return $model->status == 1 ? '已激活':'未激活';
                },
                'filter' => [1=>'已激活',0=>'未激活'],
            ],
            // 'created_at',
            // 'updated_at',
            'phone',
            [
                'attribute' => 'gender',
                'value'=> function ($model) {
                    return $model->gender == 1 ? '女':'男';
                },
                'filter' => [1=>'女',0=>'男' ],
            ],
            // 'description',
            // 'unit',
            // 'office',
            // 'goodat',
            // 'picture',
            // 'intro:ntext',
            // 'invite',
            // 'wechat',
            // 'wechat_img',
            // 'percentage',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
