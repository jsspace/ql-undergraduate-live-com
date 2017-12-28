<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\assets\AppAsset;
use backend\models\Course;

$this->title = '收入统计';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '教师列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- 课程订单 -->
<div class="course-income-list">
    <h2>普通订单</h2>
    <ul class="title">
        <li>订单号</li>
        <li>订单支付日期</li>
        <li>订单总金额</li>
        <li>订单课程</li>
        <li>教师收入</li>
    </ul>
    <?php foreach ($orders as $key => $order) {
        $order_money = $order->order_amount+$order->bonus;
    ?>
        <ul>
            <li><?= $order->order_sn ?></li>
            <li><?= date('Y-m-d H:m:s', $order->pay_time) ?></li>
            <li><?= $order_money ?></li>
            <?php
                $courses = Course::getCourse($order->course_ids);
            ?>
            <li>
                <?php
                    $course_total_price = 0;
                    $t_total_price = 0;
                    foreach ($courses as $key => $course) {
                    $course_total_price += $course->discount;
                    if (in_array($course->id, $t_course_ids) ) {
                        $t_total_price += $course->discount;
                    }
                ?>
                    <p>
                        <span>课程名：<?= $course->course_name ?></span>
                        <span>课程价格：<?= $course->discount ?></span>
                    </p>
                <?php } ?>
            </li>
            <li><?= $t_total_price/$course_total_price*$order_money*0.5 ?></li>
        </ul>
    <?php } ?>
</div>
<!-- 会员订单 -->
<div class="member-income-list">
    
</div>