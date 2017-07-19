<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '课程列表');
?>
<div class="section course-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a(Yii::t('app', '新建课程'), ['create'], ['class' => 'btn btn-default create-class']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            'course_name',
            'category_name',
            'teacher_id',
            'price',
            'discount',
            'view',
            'collection',
            'share',
            'online',
            // 'onuse',
            // 'create_time:datetime',
            'head_teacher',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
