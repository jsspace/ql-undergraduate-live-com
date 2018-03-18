<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\FriendlyLinksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '友情链接列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="friendly-links-index">
    <p>
        <?= Html::a(Yii::t('app', '新建友情链接'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
          //  'id',
            'title',
            'src',
            'position',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
