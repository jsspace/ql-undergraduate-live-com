<?php

use backend\models\User;
use backend\models\CourseCategory;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = '查看课程';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section course-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'course_name',
            [
                'attribute' => 'category_name',
                'value' => CourseCategory::getNames($model->category_name),
            ],
            [
                'attribute' => 'type',
                'value' => Lookup::item('course_type', $model->type),
            ],
            [
                'attribute' => 'open_course_url',
                'options' => ['class' => 'open_course_url'],
            ],
            //'list_pic',
            //'home_pic',
            [
                'attribute' => 'list_pic',
                'label' => '列表图片',
                'format' => ['image',['width'=>'40']]
            ],
            [
                'attribute' => 'home_pic',
                'label' => '封面图片',
                'format' => ['image',['width'=>'40']]
            ],
            [
                'attribute' => 'teacher_id',
                'value' => User::getUsernameByIds($model->teacher_id),
            ],
            //'teacher_id',
            [
                'attribute' => 'head_teacher',
                'value' => User::item($model->head_teacher),
            ],
            [
                'attribute' => 'head_teacher',
                'value' => User::item($model->head_teacher),
            ],
            //'head_teacher',
            'price',
            'discount',
            'intro',
            'des:html',
            'view',
            'collection',
            'share',
            'online',
            'position',
            [
                'attribute' => 'onuse',
                'value'=> $model->onuse == 1 ? '可用' : '不可用',
            ],
            'create_time:datetime',
        ],
    ]) ?>

</div>
<script type="text/javascript">
    var type = <?= $model->type ?>;
    if (type == 2) {
        $('.open_course_url').show();
    } else {
        $('.open_course_url').hide();
    }
</script>
