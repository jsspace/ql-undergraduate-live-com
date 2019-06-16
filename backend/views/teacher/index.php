<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TeacherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '教师列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<?php 
    //没有创建权限不显示按钮
    if(Helper::checkRoute('create')) {
    ?>
    <p>
        <?= Html::a(Yii::t('app', '创建教师'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php }?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'收入统计',
                'format'=>'raw',
                'value' => function($model){
                    $url = Url::to(['teacher/order', 'userid' => $model->id, 'username' => $model->username]);
                    return Html::a('收入统计', $url);
                }
            ],
            [
                'label'=>'提现历史',
                'format'=>'raw',
                'value' => function($model){
                    $url = Url::to(['withdraw/withdraw', 'id' => $model->id]);
                    return Html::a('提现历史', $url);
                }
            ],
            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
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
            'unit',
            // 'office',
            // 'goodat',
            // 'picture',
            // 'intro:ntext',
            // 'invite',

            [ 
                'class' => 'yii\grid\ActionColumn', 
                'template' => Helper::filterActionColumn('{view}{update}{delete}'), 
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
