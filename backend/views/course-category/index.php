<?php

use backend\models\CourseCategory;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Course Categories');
?>
<div class="section course-category-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Course Category'), ['create'], ['class' => 'btn btn-default create-class']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            'name',
            [
                'attribute' => 'parent_id',
                'value' => function ($model){
                    if ($model->parent_id==0) {
                        return '';
                    } else {
                        return CourseCategory::item($model->parent_id);
                    }
                }
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
