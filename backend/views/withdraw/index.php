<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\WithdrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Withdraws');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Withdraw'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//             'withdraw_id',
            [
                'attribute' => 'role',
                'value'=> function ($model) {
                    if ($model->role == 'marketer') {
                        return '市场专员';
                    } elseif ($model->role == 'teacher') {
                        return '教师';
                    }
                },
                'filter' => ['marketer' => '市场专员', 'teacher' => '教师'],
            ],
            [
               'attribute' => 'user_id',
               'value'=> function ($model) {
                   return User::item($model->user_id);
               },
               'filter' => User::users('marketer'),
            ],
            'fee',
            'info:ntext',
            'withdraw_date',
            'bankc_card',
            'bank',
            'bank_username',
            [
                'attribute' => 'status',
                'value'=> function ($model) {
                    if ($model->status == 0) {
                        return '未提现';
                    } elseif ($model->status == 1) {
                        return '已提现';
                    }
                },
                'filter' => [0 => '未提现', 1 => '已提现'],
            ],
            'create_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
