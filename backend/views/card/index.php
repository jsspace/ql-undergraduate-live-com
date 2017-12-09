<?php

use yii\helpers\Html;
/*use yii\grid\GridView;*/
use yii\widgets\Pjax;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cards');
$this->params['breadcrumbs'][] = $this->title;
AppAsset::addCss($this,'@web/css/card.css');
?>
<div class="card-index">
<div class="create-card">
    <span>
        金额<input type="text" class="card-money _card-money">元
    </span>
    <span class="card-num-wrap">
        随机生成<input type="text" class="card-num _card-num">张
    </span>
    <a class="commit-card _commit-card" href="javascript:void(0)">创建充值卡</a>
</div>
<?php Pjax::begin(); ?>
    <?php $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        'card_id',
        'card_pass',
        'money',
        [
            'attribute' => 'create_time',
            'value' => function($model){
                return  date('Y-m-d H:i:s',$model->create_time);
            },
        ],
        [
            'attribute' => 'print_status',
            'value'=> function ($model) {
                return $model->print_status == 1 ? '已导出':'未导出';
            },
            'filter' => [1=>'已导出',0=>'未导出' ],
        ],
         [
            'attribute' => 'use_time',
            'value' => function($model){
                return  date('Y-m-d H:i:s',$model->use_time);
            },
        ],
        'user_phone',
        [
            'attribute' => 'use_status',
            'value'=> function ($model) {
                return $model->use_status == 1 ? '已使用':'未使用';
            },
            'filter' => [1=>'已使用',0=>'未使用' ],
        ],
        ['class' => 'yii\grid\ActionColumn'],

    ];
    echo GridView::widget([
        'id' => 'kv-grid-demo',
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'toolbar' => [
            '{export}',
            '{toggleData}',
        ],
        'panel'=>[
            'type'=>GridView::TYPE_PRIMARY,
        ],
        'persistResize'=>false,
    ]);
    ?>
<?php Pjax::end(); ?></div>
<script type="text/javascript">
    $('._commit-card').on('click', function(){
        var money = $('._card-money').val();
        if (money == '') {
            alert('金额不能为空');
            return;
        }
        var num = $('._card-num').val();
        if (num == '') {
            alert('数量不能为空');
            return;
        }
        $.ajax({
            url: '/card/create',
            type: 'post',
            dataType:"json",
            data: {
                'card_num': num,
                'card_money': money,
                '_csrf-frontend': $('meta[name=csrf-token]').attr('content')
            },
            success: function(data) {
                if (data.status == "success") {
                    alert('成功创建'+data.num+"张充值卡");
                    location.reload();
                }
            }
        });
    });
</script>