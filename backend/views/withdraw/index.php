<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
use mdm\admin\components\Helper;
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
    <?php 
    //没有创建权限不显示按钮
    if(Helper::checkRoute('create')) {
    ?>
        <?= Html::a(Yii::t('app', 'Create Withdraw'), ['create'], ['class' => 'btn btn-success']) ?>
    <?php }?>
    <?php 
    //没有创建权限不显示按钮
    if(Helper::checkRoute('getlastmonthwithdraw')) {
    ?>
        <?= Html::a(Yii::t('app', 'Get last month Withdraw'), ['getlastmonthwithdraw'], ['class' => 'btn btn-success']) ?>
    <?php }?>
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
               'filter' => array_merge(User::users('marketer'), User::users('teacher')),
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

            [ 
                'class' => 'yii\grid\ActionColumn', 
                'template' => Helper::filterActionColumn('{view}{update}{delete}'), 
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
