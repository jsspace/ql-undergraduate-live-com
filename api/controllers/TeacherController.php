<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/10/010
 * Time: 10:04
 */

namespace api\controllers;

use backend\models\Course;
use backend\models\CoursePackage;
use backend\models\OrderGoods;
use backend\models\Withdraw;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use common\models\User;
use backend\models\AuthAssignment;
use backend\models\OrderInfo;

class TeacherController extends Controller
{
    /* 过滤器实现认证 */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticatior' => [
                'class' => QueryParamAuth::className()
            ]
        ]);
    }

    /* 计算总佣金及已结算金额 */
    public function actionIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            // 1、查找属于自己的课程
            $order_ids = array();   // 记录自己课程（套餐）的id并记录所占比例
            $courses_arr = array();
            $courses = Course::find()->select(['id'])->where(['teacher_id' => $user->id])->all();
            foreach ($courses as $course) {
                $order_ids[$course->id] = 1;
                $courses_arr[] = $course->id;
            }
            // 2、查找套餐内包含自己课程的套餐
            $packges = CoursePackage::find()->select(['id', 'course', 'discount'])->all();
            foreach ($packges as $package) {
                // 求数据交集，查看哪门套餐包含自己的课程
                $pack_courses_arr = explode(',', $package->course);
                $inter_arr = array_intersect($courses_arr, $pack_courses_arr);
                $include_arr = array_values($inter_arr);    // 该数组包含了每一个套餐内所含自己课程的数组
                // 计算每个套餐内自己课程所占的比例
                $pack_totle_discount = 0.0;
                $include_totle_discount = 0.0;
                $pack_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $pack_courses_arr])
                    ->all();
                // 计算套餐内所有单门课程的售价总和
                foreach ($pack_courses as $pack_course) {
                    $pack_totle_discount = $pack_totle_discount + $pack_course->discount;
                }
                $include_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $include_arr])
                    ->all();
                // 计算套餐内自己课程的售价总和
                foreach ($include_courses as $include_course) {
                    $include_totle_discount = $include_totle_discount + $include_course->discount;
                }
                $rate = $include_totle_discount / $pack_totle_discount;
                $order_ids[$package->id] = $rate;
            }
            // 查找订单信息，计算收益
            $orders = OrderGoods::find()
                ->select(['order_sn', 'goods_id'])
                ->where(['in', 'goods_id', array_keys($order_ids)])
                ->all();
            $income = 0.00;
            foreach ($orders as $order) {
                $order_sn[] = $order->order_sn;
                $order_info = OrderInfo::find()
                    ->select(['consignee', 'order_amount'])
                    ->where(['order_sn' => $order->order_sn])
                    ->andWhere(['pay_status' => 2])
                    ->andWhere(['order_status' => 1])
                    ->one();
                if (!empty($order_info)) {
                    $income = $income + ($order_info->order_amount * $order_ids[$order->goods_id] * 0.2);
                }
            }
            // 3、计算已结算金额
            $withdraw_info = Withdraw::find()->where(['user_id' => $user->id])->all();
            $withdraw_count = 0;
            foreach ($withdraw_info as $item) {
                $withdraw_count += $item->fee;
            }
            $result['status'] = 0;
            $result['income'] = round($income, 2);
            $result['settlement'] = round($withdraw_count, 2);
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已过期！';
            return json_encode($result);
        }
    }

    /* 按月统计收益和结算状态 */
    public function actionMonthIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            // 1、查找属于自己的课程
            $order_ids = array();   // 记录自己课程（套餐）的id并记录所占比例
            $courses_arr = array();
            $courses = Course::find()->select(['id'])->where(['teacher_id' => $user->id])->all();
            foreach ($courses as $course) {
                $order_ids[$course->id] = 1;
                $courses_arr[] = $course->id;
            }
            // 2、查找套餐内包含自己课程的套餐
            $packges = CoursePackage::find()->select(['id', 'course', 'discount'])->all();
            foreach ($packges as $package) {
                // 求数据交集，查看哪门套餐包含自己的课程
                $pack_courses_arr = explode(',', $package->course);
                $inter_arr = array_intersect($courses_arr, $pack_courses_arr);
                $include_arr = array_values($inter_arr);    // 该数组包含了每一个套餐内所含自己课程的数组
                // 计算每个套餐内自己课程所占的比例
                $pack_totle_discount = 0.0;
                $include_totle_discount = 0.0;
                $pack_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $pack_courses_arr])
                    ->all();
                // 计算套餐内所有单门课程的售价总和
                foreach ($pack_courses as $pack_course) {
                    $pack_totle_discount = $pack_totle_discount + $pack_course->discount;
                }
                $include_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $include_arr])
                    ->all();
                // 计算套餐内自己课程的售价总和
                foreach ($include_courses as $include_course) {
                    $include_totle_discount = $include_totle_discount + $include_course->discount;
                }
                $rate = $include_totle_discount / $pack_totle_discount;
                $order_ids[$package->id] = $rate;
            }
            // 查找订单信息，计算收益
            $orders = OrderGoods::find()
                ->select(['order_sn', 'goods_id'])
                ->where(['in', 'goods_id', array_keys($order_ids)])
                ->all();
            $income_arr = array();
            foreach ($orders as $order) {
                $order_sn[] = $order->order_sn;
                $order_info = OrderInfo::find()
                    ->select(['consignee', 'order_amount', "DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
                    ->where(['order_sn' => $order->order_sn])
                    ->andWhere(['pay_status' => 2])
                    ->andWhere(['order_status' => 1])
                    ->asArray()->one();
                if (!empty($order_info)) {
                    $income_arr[] = array(
                        'month' => $order_info['month'],
                        'income' => $order_info['order_amount'],
                        'salary' => $order_info['order_amount'] * $order_ids[$order->goods_id] * 0.2
                    );
                }
            }
            // 将月份相同的课程收益合并
            $my_income = array();
            for ($i = 0; $i < count($income_arr)-1; $i++) {
                for ($j = 0; $j < count($income_arr); $j++) {
                    if ($income_arr[$i]['month'] == $income_arr[$j]['month'] and $i != $j) {
                        $income_arr[$i]['income'] += $income_arr[$j]['income'] ;
                        $income_arr[$i]['salary'] += $income_arr[$j]['salary'] ;
                        unset($income_arr[$j]);
                        $income_arr = array_values($income_arr);
                        $j = $j-1;
                    }
                }
            }
            $my_income = $income_arr;
            // 对结果按照月份降序排序
            array_multisort(array_column($my_income,'month'),SORT_DESC,$my_income);
            foreach ($my_income as $key => $item) {
                $my_income[$key]['income'] = round($my_income[$key]['income'], 4);
                $my_income[$key]['salary'] = round($my_income[$key]['salary'], 4);
                $withdraw_info = Withdraw::find()
                    ->where(['user_id' => $user->id, 'withdraw_date' => $my_income[$key]['month']])->one();
                $my_income[$key]['status'] = !empty($withdraw_info) ? '已结算' : '未结算';
            }
            $result['status'] = 0;
            $result['my_income'] = $my_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已过期！';
            return json_encode($result);
        }
    }

    /* 按用户指定月统计收益和结算状态 */
    public function actionSelectMonthIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $start_month = $data['start_month'];
        $end_month = $data['end_month'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            // 1、查找属于自己的课程
            $order_ids = array();   // 记录自己课程（套餐）的id并记录所占比例
            $courses_arr = array();
            $courses = Course::find()->select(['id'])->where(['teacher_id' => $user->id])->all();
            foreach ($courses as $course) {
                $order_ids[$course->id] = 1;
                $courses_arr[] = $course->id;
            }
            // 2、查找套餐内包含自己课程的套餐
            $packges = CoursePackage::find()->select(['id', 'course', 'discount'])->all();
            foreach ($packges as $package) {
                // 求数据交集，查看哪门套餐包含自己的课程
                $pack_courses_arr = explode(',', $package->course);
                $inter_arr = array_intersect($courses_arr, $pack_courses_arr);
                $include_arr = array_values($inter_arr);    // 该数组包含了每一个套餐内所含自己课程的数组
                // 计算每个套餐内自己课程所占的比例
                $pack_totle_discount = 0.0;
                $include_totle_discount = 0.0;
                $pack_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $pack_courses_arr])
                    ->all();
                // 计算套餐内所有单门课程的售价总和
                foreach ($pack_courses as $pack_course) {
                    $pack_totle_discount = $pack_totle_discount + $pack_course->discount;
                }
                $include_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $include_arr])
                    ->all();
                // 计算套餐内自己课程的售价总和
                foreach ($include_courses as $include_course) {
                    $include_totle_discount = $include_totle_discount + $include_course->discount;
                }
                $rate = $include_totle_discount / $pack_totle_discount;
                $order_ids[$package->id] = $rate;
            }
            // 查找订单信息，计算收益
            $orders = OrderGoods::find()
                ->select(['order_sn', 'goods_id'])
                ->where(['in', 'goods_id', array_keys($order_ids)])
                ->all();
            $income_arr = array();
            foreach ($orders as $order) {
                $order_sn[] = $order->order_sn;
                $order_info = OrderInfo::find()
                    ->select(['consignee', 'order_amount', "DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
                    ->where(['order_sn' => $order->order_sn])
                    ->andWhere(['>','pay_time' , strtotime($start_month)])
                    ->andWhere(['<','pay_time' , strtotime($end_month)])
                    ->andWhere(['pay_status' => 2])
                    ->andWhere(['order_status' => 1])
                    ->asArray()->one();
                if (!empty($order_info)) {
                    $income_arr[] = array(
                        'month' => $order_info['month'],
                        'income' => $order_info['order_amount'],
                        'salary' => $order_info['order_amount'] * $order_ids[$order->goods_id] * 0.2
                    );
                }
            }
            // 将月份相同的课程收益合并
            $my_income = array();
            for ($i = 0; $i < count($income_arr)-1; $i++) {
                for ($j = 0; $j < count($income_arr); $j++) {
                    if ($income_arr[$i]['month'] === $income_arr[$j]['month'] and $i != $j) {
                        $income_arr[$i]['income'] += $income_arr[$j]['income'] ;
                        $income_arr[$i]['salary'] += $income_arr[$j]['salary'] ;
                        unset($income_arr[$j]);
                        $income_arr = array_values($income_arr);
                        $j = $j-1;
                    }
                }
            }
            $my_income = $income_arr;
            // 对结果按照月份降序排序
            array_multisort(array_column($my_income,'month'),SORT_DESC,$my_income);
            foreach ($my_income as $key => $item) {
                $my_income[$key]['income'] = round($my_income[$key]['income'], 4);
                $my_income[$key]['salary'] = round($my_income[$key]['salary'], 4);
                $withdraw_info = Withdraw::find()
                    ->where(['user_id' => $user->id, 'withdraw_date' => $my_income[$key]['month']])->one();
                $my_income[$key]['status'] = !empty($withdraw_info) ? '已结算' : '未结算';
            }
            $result['status'] = 0;
            $result['my_income'] = $my_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已过期！';
            return json_encode($result);
        }
    }

    /* 所有收益明细列表 */
    public function actionIncomeDetail()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            // 1、查找属于自己的课程
            $order_ids = array();   // 记录自己课程（套餐）的id并记录所占比例
            $courses_arr = array();
            $courses = Course::find()->select(['id'])->where(['teacher_id' => $user->id])->all();
            foreach ($courses as $course) {
                $order_ids[$course->id] = 1;
                $courses_arr[] = $course->id;
            }
            // 2、查找套餐内包含自己课程的套餐
            $packges = CoursePackage::find()->select(['id', 'course', 'discount'])->all();
            foreach ($packges as $package) {
                // 求数据交集，查看哪门套餐包含自己的课程
                $pack_courses_arr = explode(',', $package->course);
                $inter_arr = array_intersect($courses_arr, $pack_courses_arr);
                $include_arr = array_values($inter_arr);    // 该数组包含了每一个套餐内所含自己课程的数组
                // 计算每个套餐内自己课程所占的比例
                $pack_totle_discount = 0.0;
                $include_totle_discount = 0.0;
                $pack_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $pack_courses_arr])
                    ->all();
                // 计算套餐内所有单门课程的售价总和
                foreach ($pack_courses as $pack_course) {
                    $pack_totle_discount = $pack_totle_discount + $pack_course->discount;
                }
                $include_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $include_arr])
                    ->all();
                // 计算套餐内自己课程的售价总和
                foreach ($include_courses as $include_course) {
                    $include_totle_discount = $include_totle_discount + $include_course->discount;
                }
                $rate = $include_totle_discount / $pack_totle_discount;
                $order_ids[$package->id] = $rate;
            }
            // 查找订单信息，计算收益
            $orders = OrderGoods::find()
                ->select(['order_sn', 'goods_id'])
                ->where(['in', 'goods_id', array_keys($order_ids)])
                ->all();
            $income_detail = array();
            foreach ($orders as $order) {
                $order_sn[] = $order->order_sn;
                $order_info = OrderInfo::find()
                    ->select(['consignee', 'order_amount', 'user_id', 'pay_time'])
                    ->where(['order_sn' => $order->order_sn])
                    ->andWhere(['pay_status' => 2])
                    ->andWhere(['order_status' => 1])
                    ->one();
                if (!empty($order_info)) {
                    $userpic = User::find()->select(['picture'])
                        ->where(['id' => $order_info->user_id])
                        ->one();
                    $income_content = array(
                        'pic' => $userpic->picture,
                        'consignee' => $order_info->consignee,
                        'status' => '下单',
                        'income' => round($order_info['order_amount'] * $order_ids[$order->goods_id] * 0.2, 4),
                        'pay_time' => date('Y-m-d H:i:s', $order_info->pay_time)
                    );
                    $income_detail[] = $income_content;
                }
            }
            $result['status'] = 0;
            $result['income_detail'] = $income_detail;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已过期！';
            return json_encode($result);
        }
    }

    /* 按用户选择的月份查询明细 */
    public function actionSelectIncomeDetail()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $month = $data['month'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            // 1、查找属于自己的课程
            $order_ids = array();   // 记录自己课程（套餐）的id并记录所占比例
            $courses_arr = array();
            $courses = Course::find()->select(['id'])->where(['teacher_id' => $user->id])->all();
            foreach ($courses as $course) {
                $order_ids[$course->id] = 1;
                $courses_arr[] = $course->id;
            }
            // 2、查找套餐内包含自己课程的套餐
            $packges = CoursePackage::find()->select(['id', 'course', 'discount'])->all();
            foreach ($packges as $package) {
                // 求数据交集，查看哪门套餐包含自己的课程
                $pack_courses_arr = explode(',', $package->course);
                $inter_arr = array_intersect($courses_arr, $pack_courses_arr);
                $include_arr = array_values($inter_arr);    // 该数组包含了每一个套餐内所含自己课程的数组
                // 计算每个套餐内自己课程所占的比例
                $pack_totle_discount = 0.0;
                $include_totle_discount = 0.0;
                $pack_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $pack_courses_arr])
                    ->all();
                // 计算套餐内所有单门课程的售价总和
                foreach ($pack_courses as $pack_course) {
                    $pack_totle_discount = $pack_totle_discount + $pack_course->discount;
                }
                $include_courses = Course::find()->select(['discount'])
                    ->where(['in', 'id', $include_arr])
                    ->all();
                // 计算套餐内自己课程的售价总和
                foreach ($include_courses as $include_course) {
                    $include_totle_discount = $include_totle_discount + $include_course->discount;
                }
                $rate = $include_totle_discount / $pack_totle_discount;
                $order_ids[$package->id] = $rate;
            }
            // 查找订单信息，计算收益
            $orders = OrderGoods::find()
                ->select(['order_sn', 'goods_id'])
                ->where(['in', 'goods_id', array_keys($order_ids)])
                ->all();
            $income_detail = array();
            foreach ($orders as $order) {
                $order_sn[] = $order->order_sn;
                $order_info = OrderInfo::find()
                    ->select(['consignee', 'order_amount', 'user_id', 'pay_time'])
                    ->where(['order_sn' => $order->order_sn])
                    ->andWhere(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m')" => $month])
                    ->andWhere(['pay_status' => 2])
                    ->andWhere(['order_status' => 1])
                    ->one();
                if (!empty($order_info)) {
                    $userpic = User::find()->select(['picture'])
                        ->where(['id' => $order_info->user_id])
                        ->one();
                    $income_content = array(
                        'pic' => $userpic->picture,
                        'consignee' => $order_info->consignee,
                        'status' => '下单',
                        'income' => round($order_info['order_amount'] * $order_ids[$order->goods_id] * 0.2, 4),
                        'pay_time' => date('Y-m-d H:i:s', $order_info->pay_time)
                    );
                    $income_detail[] = $income_content;
                }
            }
            $result['status'] = 0;
            $result['income_detail'] = $income_detail;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已过期！';
            return json_encode($result);
        }
    }
}