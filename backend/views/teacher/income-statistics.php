<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\assets\AppAsset;
use backend\models\Course;
use yii\widgets\LinkPager;

$this->title = '收入统计';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '教师列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AppAsset::addCss($this, '@web/css/teacher-statistic.css');

?>
<!-- 课程订单 -->
<div class="course-income-list list">
    <h2>普通订单</h2>
    <ul class="title">
        <li>订单号</li>
        <li>订单支付日期</li>
        <li>订单总金额</li>
        <li>订单课程</li>
        <li>教师收入</li>
    </ul>
    <?php
        $total_income = 0;
        foreach ($orders as $key => $order) {
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
                        <span><?= $course->course_name ?>：</span>
                        <span><?= $course->discount ?>元</span>
                    </p>
                <?php } ?>
            </li>
            <li>
                <?php
                $current_income = $t_total_price/$course_total_price*$order_money*0.5;
                $total_income = $total_income + $current_income;
                echo '该教师课程总价/课程总价*订单金额*50%=' . $current_income.'元'; ?>
            </li>
        </ul>
    <?php } 
    // 显示分页
    echo LinkPager::widget([
        'pagination' => $pagination,
        'firstPageLabel'=>"First",
        'prevPageLabel'=>'Prev',
        'nextPageLabel'=>'Next',
        'lastPageLabel'=>'Last',
    ]);
    
    ?>

    <div class="total-income">总收入：<?= $teacher_total_income ?>元</div>
    <div class="total-income">总提现金额：<?= $total_withdraw ?>元</div>
</div>
<!-- 会员订单 -->
<!-- <div class="member-income-list list">
    <h2>会员订单</h2>
    <ul class="title">
        <li>订单号</li>
        <li>订单支付日期</li>
        <li>订单总金额</li>
        <li>订单课程</li>
        <li>教师收入</li>
    </ul>
    <?php
        $total_income = 0;
        foreach ($orders as $key => $order) {
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
                        <span><?= $course->course_name ?>：</span>
                        <span><?= $course->discount ?>元</span>
                    </p>
                <?php } ?>
            </li>
            <li>
                <?php
                $current_income = $t_total_price/$course_total_price*$order_money*0.5;
                $total_income = $total_income + $current_income;
                echo '该教师课程总价/课程总价*订单金额*50%=' . $current_income.'元'; ?>
            </li>
        </ul>
    <?php } ?>
    <div class="total-income">总收入：<?= $total_income.'元' ?></div>
</div> -->