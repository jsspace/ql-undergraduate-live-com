<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\User;
use backend\models\CourseCategory;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoursePackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Course Packages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-package-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Course Package'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            /*[
                'label'=>'课程',
                'format'=>'raw',
                'value' => function($model){
                    $url = Url::to(['course-package/editcourse', 'package_id' => $model->id]);
                    return Html::a('编辑课程', $url);
                }
            ],*/
            'name',
            [
                'attribute' => 'category_name',
                'value'=> function ($model) {
                    return CourseCategory::getNames($model->category_name);
                }
            ],
            'price',
            'discount',
            'view',
            'collection',
            'share',
            'online',
            [
                'attribute' => 'onuse',
                'value'=> function ($model) {
                    return $model->onuse == 1 ? '可用':'不可用';
                },
                'filter' => [1=>'可用',0=>'不可用' ],
            ],
            [
                'attribute' => 'head_teacher',
                'value'=> function ($model) {
                    return User::item($model->head_teacher);
                },
                'filter' => User::users('head_teacher'),
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
