<?php
/**
 * Created by PhpStorm.
 * User: DHZ
 * Date: 2019/3/25/025
 * Time: 19:23
 */
namespace api\controllers;

use backend\models\Withdraw;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use common\models\User;
use backend\models\AuthAssignment;
use backend\models\OrderInfo;

class MarketController extends Controller
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

    /* 代理添加 */
    public function actionAddMarketer()
    {
        $data = Yii::$app->request->get();
        $result = array();
        if ($data['access-token']) {
            $access_token = $data['access-token'];
            $user = User::findIdentityByAccessToken($access_token);
            if (!empty($user)) {
                $data = Yii::$app->request->post();
                $user_name = $data['username'];     // 用户名
                $phone = $data['phone'];        // 电话号码
                $password = $data['password'];  // 密码
                $g = "/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/";
                if (!preg_match($g, $phone)) {
                    $result['status'] = -1;
                    $result['message'] = '请输入正确的手机号码!';
                    return json_encode($result);
                }
                $marketer = new User();
                $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
                $role = '';
                if (array_key_exists('marketer',$roles_array)) {
                    $role = 'marketer_level1';
                } else if (array_key_exists('marketer_level1',$roles_array)) {
                    $role = 'marketer_level2';
                } else if (array_key_exists('marketer_level2',$roles_array)) {
                    $result['status'] = -1;
                    $result['message'] = '没有权限进行添加代理操作！';
                    return $result;
                }
                $marketer->username = $user_name;
                $marketer->phone = $phone;
                if ($password == '' || empty($password) || $password == null) {
                    $marketer->setPassword('123456');
                }
                $marketer->setPassword($password);
                $marketer->invite = $user->id;
                $marketer->generateAuthKey();
                if ($marketer->save()) {
                    $marketer_role = new AuthAssignment();
                    $marketer_role->item_name = $role;
                    $marketer_role->user_id = $marketer->id;
                    $marketer_role->created_at = time();
                    $marketer_role->save(false);
                } else {
                    $result['status'] = -1;
                    $result['message'] = '用户创建失败，请再尝试一次！';
                    return json_encode($result);
                }
                $result['status'] = 0;
                $result['message'] = '添加成功';
                return json_encode($result);
            }
        }
        $result['status'] = -1;
        $result['message'] = '用户未找到或用户登录已过期！';
        return json_encode($result);
    }

    /* 下级代理列表 */
    public function actionMarketerList()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $market_lists = array();
        $result = array();
        if (!empty($user)) {
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('marketer',$roles_array)) {
                $market_list = User::find()
                    ->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level1']);
                    }])
                    ->all();
                $roleName = '一级代理';
            } else if (array_key_exists('marketer_level1',$roles_array)) {
                $market_list = User::find()
                    ->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level2']);
                    }])
                    ->all();
                $roleName = '二级代理';
            }
            foreach($market_list as $list) {
                if (count($list->role)) {
                    $market_lists[] = array (
                        'id' => $list->id,
                        'username' =>  $list->username,
                        'phone' => $list->phone,
                        'role' => $roleName
                    );
                }
            }
            $result['status'] = 0;
            $result['list'] = $market_lists;
            return json_encode($result);
        }
        $result['status'] = -1;
        $result['message'] = '用户未找到或登录已过期！';
        return json_encode($result);
    }

    /* 获取代理信息 */
    public function actionMarketerOne()
    {
        $data = Yii::$app->request->get();
        $user_id = $data['userid'];
        $marketer = User::findIdentity($user_id);
        $result = array();
        if (!empty($marketer)) {
            $result['data'] = array (
                'username' => $marketer->username,
                'phone' => $marketer->phone
            );
            $result['status'] = 0;
        } else {
            $result['status'] = -1;
            $result['message'] = '该用户不存在';
        }
        return json_encode($result);
    }
    
    /* 更新代理信息 */
    public function actionUpdateMarketer()
    {
        $data = Yii::$app->request->get();
        $result = array();
        if ($data['access-token']) {
            $access_token = $data['access-token'];
            $user = User::findIdentityByAccessToken($access_token);
            if (!empty($user)) {
                $data = Yii::$app->request->post();
                $marketer = User::findIdentity($data['userid']);
                if ($marketer && $marketer->invite === $user->id) {
                    $user_name = $data['username'];     // 用户名
                    $phone = $data['phone'];        // 电话号码
                    $password = $data['password'];  // 密码
                    $g = "/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/";
                    if (!preg_match($g, $phone)) {
                        $result['status'] = -1;
                        $result['message'] = '请输入正确的手机号码!';
                        return json_encode($result);
                    }
                    $marketer->username = $user_name;
                    $marketer->phone = $phone;
                    $marketer->setPassword($password);
                    if ($marketer->save()) {
                        $result['status'] = 0;
                        $result['message'] = '更新成功';
                        return json_encode($result);
                    } else {
                        $result['status'] = -1;
                        $result['message'] = '更新失败，请再尝试一次！';
                        return json_encode($result);
                    }
                } else {
                    $result['status'] = -1;
                    $result['message'] = '您没有权限操作该用户';
                    return json_encode($result);
                }
            } else {
                $result['status'] = -1;
                $result['message'] = '用户未找到或用户登录已过期！';
                return json_encode($result);
            }
        } else {
            $result['status'] = -1;
            $result['message'] = '参数不正确';
            return json_encode($result);
        }
    }
    /* 删除代理信息 */
    public function actionDelSubordinate() {
        $data = Yii::$app->request->get();
        $user = User::findIdentityByAccessToken($data['access-token']);
        $marketer = User::findIdentity($data['userid']);
        if ($user && $marketer && $marketer->invite === $user->id) {
            if ($marketer->delete()) {
                AuthAssignment::find()
                ->where(['user_id' => $marketer->id])
                ->one()
                ->delete();
                $result['status'] = 0;
                $result['message'] = '删除成功';
            } else {
                $result['status'] = -1;
                $result['message'] = '删除失败';
            }
        } else {
            $result['status'] = -1;
            $result['message'] = '您没有权限操作该用户';
        }
        return json_encode($result);
    }

    /* 计算代理的佣金和已结算总金额 */
    public function actionIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            // 1、计算直接收益（即自己邀请的学员购买课程的提成）
            $students = User::find()->where(['invite' => $user->id])->all();
            $student_array=array();
            foreach ($students as $student) {
                $student_array[] = $student->id;
            }
            $orders = OrderInfo::find()
                ->where(['in', 'user_id', $student_array])
                ->andWhere(['order_status' => 1])
                ->andWhere(['pay_status' => 2])
                ->all();
            $income = 0;
            $next_income = 0;
            foreach ($orders as $order) {
                $income += $order->goods_amount;
            }

            // 2、计算间接收益（即自己的下级代理所邀请的学生购课的提成）
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('marketer',$roles_array)) {
                // 查找用户的直接下级
               $marketers = User::find()->where(['invite' => $user->id])
                   ->with(['role' => function($query) {
                       $query->where("item_name='marketer_level1'");
                   }])->all();
               // 循环计算各个下级所获得的佣金
                foreach ($marketers as $marketer) {
                    if (!empty($marketer->role)) {
                        $stus = User::find()->where(['invite' => $marketer->id])->all();
                        $students_array=array();
                        foreach ($stus as $stu) {
                            $students_array[] = $stu->id;
                        }
                        $ords = OrderInfo::find()
                            ->where(['in', 'user_id', $students_array])
                            ->andWhere(['order_status' => 1])
                            ->andWhere(['pay_status' => 2])
                            ->all();
                        foreach ($ords as $ord) {
                            $next_income += $ord->order_amount;
                        }
                        $next_income = $next_income * 0.2;
                    }
                }
            } else if (array_key_exists('marketer_level1',$roles_array)) {
                // 查找用户的直接下级
                $marketers = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level2']);
                    }])->all();
                // 循环计算各个下级所获得的佣金
                foreach ($marketers as $marketer) {
                    if (!empty($marketer->role)) {
                        $stus = User::find()->where(['invite' => $marketer->id])->all();
                        $students_array=array();
                        foreach ($stus as $stu) {
                            $students_array[] = $stu->id;
                        }
                        $ords = OrderInfo::find()
                            ->where(['in', 'user_id', $students_array])
                            ->andWhere(['order_status' => 1])
                            ->andWhere(['pay_status' => 2])
                            ->all();
                        foreach ($ords as $ord) {
                            $next_income += $ord->order_amount;
                        }
                        $next_income = $next_income * 0.2;
                    }
                }
            }

            // 3、计算已结算总金额
            $withdraw_info = Withdraw::find()->where(['user_id' => $user->id])->all();
            $withdraw_count = 0;
            foreach ($withdraw_info as $item) {
                $withdraw_count += $item->fee;
            }

            $income = round(($income + $next_income)*0.2, 2) ;
            $result['status'] = 0;
            $result['income'] = $income;
            $result['settlement'] = round($withdraw_count, 2);
            return json_encode($result);
        }
        $result['status'] = -1;
        $result['message'] = '用户未找到或登录已过期！';
        return json_encode($result);
    }

    /* 按月统计代理的提成收益 */
    public function actionMonthIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            // 1、按照月份计算直接收益
            $students = User::find()->where(['invite' => $user->id])->all();
            $students_array = array();
            foreach ($students as $student) {
                $students_array[] = $student->id;
            }
            $direct_orders = OrderInfo::find()
                ->select(["sum(goods_amount) as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
                ->where(['in', 'user_id', $students_array])
                ->andWhere(['order_status' => 1])->andWhere(['pay_status' => 2])
                ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])->asArray()->all();

            // 2、计算间接间接收益
            $indirect_income = array();
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('marketer',$roles_array)) {
                $marketers = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level1']);
                    }])->all();
                // 循环计算每个直接下级代理的收益
                foreach ($marketers as $marketer) {
                    $stus = User::find()->where(['invite' => $marketer->id])->all();
                    $stu_ids = array();
                    foreach ($stus as $stu) {
                        $stu_ids[] = $stu->id;
                    }
                    $orders = OrderInfo::find()
                        ->select(["sum(goods_amount)*0.2 as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
                        ->where(['in', 'user_id', $stu_ids])
                        ->andWhere(['order_status' => 1])->andWhere(['pay_status' => 2])
                        ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])->asArray()->all();
                    if (count($orders) != 0) {
                        foreach ($orders as $order) {
                            $indirect_income[] = $order;
                        }
                    }
                }
            } elseif (array_key_exists('marketer_level1', $roles_array)) {
                $marketers = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level2']);
                    }])->all();
                // 循环计算每个直接下级代理的收益
                foreach ($marketers as $marketer) {
                    $stus = User::find()->where(['invite' => $marketer->id])->all();
                    $stu_ids = array();
                    foreach ($stus as $stu) {
                        $stu_ids[] = $stu->id;
                    }
                    $orders = OrderInfo::find()
                        ->select(["sum(goods_amount*0.2) as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
                        ->where(['in', 'user_id', $stu_ids])
                        ->andWhere(['order_status' => 1])->andWhere(['pay_status' => 2])
                        ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])->asArray()->all();
                    if (count($orders) != 0) {
                        $indirect_income[] = $orders;
                    }
                }
            }
            $my_income = array_merge($direct_orders, $indirect_income);
            for ($i = 0; $i < count($my_income)-1; $i++) {
                for ($j = 0; $j < count($my_income); $j++) {
                    if ($my_income[$i]['month'] == $my_income[$j]['month'] and $i != $j) {
                        $my_income[$i]['income'] += $my_income[$j]['income'] ;
                        unset($my_income[$j]);
                        $my_income = array_values($my_income);
                    }
                }
            }
            array_multisort(array_column($my_income,'month'),SORT_DESC,$my_income);
            foreach ($my_income as $key => $item) {
                $my_income[$key]['income'] = round($my_income[$key]['income'], 2);
                $my_income[$key]['salary'] = round($my_income[$key]['income']*0.2, 2);
                $my_income[$key]['status'] = '未结算';
            }
            $result['status'] = 0;
            $result['direct_income'] = $direct_orders;
            $result['indirect_income'] = $indirect_income;
            $result['my_income'] = $my_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已超时！';
            return json_encode($result);
        }
    }

    /* 按用户选择月份区间统计代理的提成收益 */
    public function actionSelectMonthIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $start_month = $data['start_month'];
        $end_month = $data['end_month'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            // 1、按照月份计算直接收益
            $students = User::find()->where(['invite' => $user->id])->all();
            $students_array = array();
            foreach ($students as $student) {
                $students_array[] = $student->id;
            }
            $direct_orders = OrderInfo::find()
                ->select(["sum(goods_amount) as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
                ->where(['in', 'user_id', $students_array])
                ->andWhere(['>','pay_time' , strtotime($start_month)])
                ->andWhere(['<','pay_time' , strtotime($end_month)])
                ->andWhere(['order_status' => 1])->andWhere(['pay_status' => 2])
                ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])->asArray()->all();

            // 2、计算间接间接收益
            $indirect_income = array();
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('marketer',$roles_array)) {
                $marketers = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level1']);
                    }])->all();
                // 循环计算每个直接下级代理的收益
                foreach ($marketers as $marketer) {
                    $stus = User::find()->where(['invite' => $marketer->id])->all();
                    $stu_ids = array();
                    foreach ($stus as $stu) {
                        $stu_ids[] = $stu->id;
                    }
                    $orders = OrderInfo::find()
                        ->select(["sum(goods_amount)*0.2 as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
                        ->where(['in', 'user_id', $stu_ids])
                        ->andWhere(['>=','pay_time' , strtotime($start_month)])
                        ->andWhere(['<=','pay_time' , strtotime($end_month)])
                        ->andWhere(['order_status' => 1])->andWhere(['pay_status' => 2])
                        ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])->asArray()->all();
                    if (count($orders) != 0) {
                        foreach ($orders as $order) {
                            $indirect_income[] = $order;
                        }
                    }
                }
            } elseif (array_key_exists('marketer_level1', $roles_array)) {
                $marketers = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level2']);
                    }])->all();
                // 循环计算每个直接下级代理的收益
                foreach ($marketers as $marketer) {
                    $stus = User::find()->where(['invite' => $marketer->id])->all();
                    $stu_ids = array();
                    foreach ($stus as $stu) {
                        $stu_ids[] = $stu->id;
                    }
                    $orders = OrderInfo::find()
                        ->select(["sum(goods_amount*0.2) as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
                        ->where(['in', 'user_id', $stu_ids])
                        ->andWhere(['>=','pay_time' , strtotime($start_month)])
                        ->andWhere(['=<','pay_time' , strtotime($end_month)])
                        ->andWhere(['order_status' => 1])->andWhere(['pay_status' => 2])
                        ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])->asArray()->all();
                    if (count($orders) != 0) {
                        $indirect_income[] = $orders;
                    }
                }
            }
            $my_income = array_merge($direct_orders, $indirect_income);
            for ($i = 0; $i < count($my_income)-1; $i++) {
                for ($j = 0; $j < count($my_income); $j++) {
                    if ($my_income[$i]['month'] == $my_income[$j]['month'] and $i != $j) {
                        $my_income[$i]['income'] += $my_income[$j]['income'] ;
                        unset($my_income[$j]);
                        $my_income = array_values($my_income);
                    }
                }
            }
            array_multisort(array_column($my_income,'month'),SORT_DESC,$my_income);
            foreach ($my_income as $key => $item) {
                $my_income[$key]['income'] = round($my_income[$key]['income'], 2);
                $my_income[$key]['salary'] = round($my_income[$key]['income']*0.2, 2);
            }
            $result['status'] = 0;
            $result['direct_income'] = $direct_orders;
            $result['indirect_income'] = $indirect_income;
            $result['my_income'] = $my_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已超时！';
            return json_encode($result);
        }
    }

    /* 查询直接收益明细 */
    public function actionDirectIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $month = $data['month'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);

        if (!empty($user)) {
            $direct_income = array();
            $user_array = array();
            // 1、查询直接注册的用户
            $invite_users = User::find()->where(['invite' => $user->id])->all();
            foreach ($invite_users as $u) {
                $register_content = array(
                    'pic' => $u->picture,
                    'consignee' => $u->username,
                    'status' => '注册',
                    'income' =>  0,
                    'pay_time' => date('Y-m-d H:i:s', $u->created_at)
                );
                $direct_income[] = $register_content;
                $user_array[] = $u->id;
            }
            // 2、根据直接注册的用户查询邀请的用户下单情况并计算收益
            $orders = OrderInfo::find()->select(['consignee', 'goods_amount', 'pay_time', 'user_id'])
                ->where(['in', 'user_id', $user_array])
                ->andWhere(['order_status' => 1])
                ->andWhere(['pay_status' => 2])
                ->all();
            foreach ($orders as $order) {
                $userpic = User::find()->select(['picture'])
                    ->where(['id' => $order->user_id])
                    ->one();
                $order_content = array(
                    'pic' => $userpic->picture,
                    'consignee' => $order->consignee,
                    'status' => '下单',
                    'income' => round($order->goods_amount * 0.2, 2),
                    'pay_time' => date('Y-m-d H:i:s', $order->pay_time)
                );
                $direct_income[] = $order_content;
            }
            array_multisort(array_column($direct_income,'pay_time'),SORT_DESC, $direct_income);
            $result['status'] = 0;
            $result['direct_income'] = $direct_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已超时!';
            return json_encode($result);
        }
    }

    /* 按照指定月份查询直接收益明细 */
    public function actionMonthDirectIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $month = $data['month'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);

        if (!empty($user)) {
            $direct_income = array();
            $user_array = array();
            // 1、查询直接注册的用户
            $invite_users = User::find()->where(['invite' => $user->id, "DATE_FORMAT(FROM_UNIXTIME(created_at, '%Y-%m-%d'), '%Y-%m')" => $month])->all();
            foreach ($invite_users as $u) {
                $register_content = array(
                    'pic' => $u->picture,
                    'consignee' => $u->username,
                    'status' => '注册',
                    'income' =>  0,
                    'pay_time' => date('Y-m-d H:i:s', $u->created_at)
                );
                $direct_income[] = $register_content;
            }
            // 2、根据直接注册的用户查询邀请的用户下单情况并计算收益
            $all_invite_users = User::find()->select(['id'])->where(['invite' => $user->id])->all();
            foreach ($all_invite_users as $user) {
                $user_array[] = $user->id;
            }
            $orders = OrderInfo::find()->select(['consignee', 'goods_amount', 'pay_time', 'user_id'])
                ->where(['in', 'user_id', $user_array])
                ->andWhere(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m')" => $month])
                ->andWhere(['order_status' => 1])
                ->andWhere(['pay_status' => 2])
                ->all();
            foreach ($orders as $order) {
                $userpic = User::find()->select(['picture'])
                    ->where(['id' => $order->user_id])
                    ->one();
                $order_content = array(
                    'pic' => $userpic->picture,
                    'consignee' => $order->consignee,
                    'status' => '下单',
                    'income' => round($order->goods_amount * 0.2, 2),
                    'pay_time' => date('Y-m-d H:i:s', $order->pay_time)
                );
                $direct_income[] = $order_content;
            }
            array_multisort(array_column($direct_income,'pay_time'),SORT_DESC, $direct_income);
            $result['status'] = 0;
            $result['direct_income'] = $direct_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已超时!';
            return json_encode($result);
        }
    }

    /* 查询间接收益明细 */
    public function actionIndirectIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $month = $data['month'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);

        if (!empty($user)) {
            // 1、查找自己的直接下级代理
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('marketer', $roles_array)) {
                $marketers = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level1']);
                    }])->all();
            } elseif (array_key_exists('marketer_level1', $roles_array)) {
                $marketers = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level2']);
                    }])->all();
            }
            $indirect_income = array();
            // 2、查找每个直接下级代理所邀请的学生的订单
            foreach ($marketers as $marketer) {
                // 查找每个下级代理所邀请的学生
                $students = User::find()->select(['id'])
                    ->where(['invite' => $marketer->id])->all();
                $student_array = array();
                foreach ($students as $student) {
                    $student_array[] = $student->id;
                }
                $orders = OrderInfo::find()->select(['consignee', 'goods_amount', 'pay_time', 'user_id'])
                    ->where(['in', 'user_id', $student_array])
                    ->andWhere(['order_status' => 1])
                    ->andWhere(['pay_status' => 2])
                    ->all();

                // 3、将订单信息添加到数组并计算该笔订单的间接收益
                foreach ($orders as $order) {
                    $userpic = User::find()->select(['picture'])
                        ->where(['id' => $order->user_id])
                        ->one();
                    $order_content = array(
                        'pic' => $userpic->picture,
                        'consignee' => $order->consignee,
                        'status' => '下单',
                        'invite' => $marketer->username,
                        'income' => $order->goods_amount*0.2*0.2,
                        'pay_time' => date('Y-m-d H:i:s', $order->pay_time)
                    );
                    $indirect_income[] = $order_content;
                }
            }
            $result['status'] = 0;
            $result['indirect_income'] = $indirect_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已超时!';
            return json_encode($result);
        }
    }

    /* 按指定月份查询间接收益明细 */
    public function actionMonthIndirectIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $month = $data['month'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);

        if (!empty($user)) {
            // 1、查找自己的直接下级代理
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('marketer', $roles_array)) {
                $marketers = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level1']);
                    }])->all();
            } elseif (array_key_exists('marketer_level1', $roles_array)) {
                $marketers = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level2']);
                    }])->all();
            }
            $indirect_income = array();
            // 2、查找每个直接下级代理所邀请的学生的订单
            foreach ($marketers as $marketer) {
                // 查找每个下级代理所邀请的学生
                $students = User::find()->select(['id'])
                    ->where(['invite' => $marketer->id])->all();
                $student_array = array();
                foreach ($students as $student) {
                    $student_array[] = $student->id;
                }
                $orders = OrderInfo::find()->select(['consignee', 'goods_amount', 'pay_time', 'user_id'])
                    ->where(['in', 'user_id', $student_array])
                    ->andWhere(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m')" => $month])
                    ->andWhere(['order_status' => 1])
                    ->andWhere(['pay_status' => 2])
                    ->all();

                // 3、将订单信息添加到数组并计算该笔订单的间接收益
                foreach ($orders as $order) {
                    $userpic = User::find()->select(['picture'])
                        ->where(['id' => $order->user_id])
                        ->one();
                    $order_content = array(
                        'pic' => $userpic->picture,
                        'consignee' => $order->consignee,
                        'status' => '下单',
                        'invite' => $marketer->username,
                        'income' => $order->goods_amount*0.2*0.2,
                        'pay_time' => date('Y-m-d H:i:s', $order->pay_time)
                    );
                    $indirect_income[] = $order_content;
                }
            }
            $result['status'] = 0;
            $result['indirect_income'] = $indirect_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已超时!';
            return json_encode($result);
        }
    }
}