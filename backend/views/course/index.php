<?php

use backend\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
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
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'label'=>'章节',
                'format'=>'raw',
                'value' => function($model){
                    $url = Url::to(['course-chapter/index', 'course_id' => $model->id]);
                    return Html::a('编辑章节', $url);
                }
            ],
            'course_name',
            [
                'attribute' => 'teacher_id',
                'value'=> function ($model) {
                    return User::item($model->teacher_id);
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
            // 'create_time:datetime',
            [
                'attribute' => 'head_teacher',
                'value'=> function ($model) {
                    return User::item($model->head_teacher);
                }
            ],
        ],
    ]); ?>
</div>
