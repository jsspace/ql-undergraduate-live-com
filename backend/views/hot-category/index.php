<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\CourseCategory;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\HotCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Hot Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hot-category-index">
    <p>
        <?= Html::a(Yii::t('app', 'Create Hot Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute' => 'categoryid',
                'value'=> function ($model) {
                    return CourseCategory::item($model->categoryid);
                }
            ],
            [
                'attribute' => 'icon',
                'format' => [
                    'image', 
                    [
                        'width'=>'20',
                    ]
                ],
            ],
            'backgroundcolor',
            'title',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
