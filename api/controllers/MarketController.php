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
    static $next_income = 0;
    const INCOMEP = 0.2; // 直接收益提成
    const INCOMENEXTP = 0.2; // 间接收益提成
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
                // 判断重复
                $findUser = User::find()->where(['phone' => $phone])->one();
                if (!empty($findUser)) {
                    $result['status'] = -1;
                    $result['message'] = '该手机号已注册！';
                    return json_encode($result);
                }
                $marketer = new User();
                // $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
                $role = 'marketer';
                // if (array_key_exists('marketer',$roles_array)) {
                //     $role = 'marketer_level1';
                // } else if (array_key_exists('marketer_level1',$roles_array)) {
                //     $role = 'marketer_level2';
                // } else if (array_key_exists('marketer_level2',$roles_array)) {
                //     $result['status'] = -1;
                //     $result['message'] = '没有权限进行添加代理操作！';
                //     return $result;
                // }
                $marketer->username = $user_name;
                $marketer->phone = $phone;
                if (empty($password)) {
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
            $market_list = User::find()
            ->where(['invite' => $user->id])
            ->with(['role' => function($query) {
                $query->andWhere(['item_name' => 'marketer']);
            }])
            ->all();
            $roleName = '下级代理';
            foreach($market_list as $list) {
                if (count($list->role) > 0) {
                    $amount = self::getAllIncome($list->id);
                    $market_lists[] = array (
                        'id' => $list->id,
                        'username' =>  $list->username,
                        'phone' => $list->phone,
                        'role' => $roleName,
                        'income' => $amount
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

    /* 计算代理的佣金和已结算总金额 @zhang */
    public function actionIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            $amount = self::getAllIncome($user->id);
            // 3、计算已结算总金额
             $withdraw_info = Withdraw::find()->where(['user_id' => $user->id])->all();
             $withdraw_count = 0;
             foreach ($withdraw_info as $item) {
                $withdraw_count += $item->fee;
            }
            $result = array(
                'status' => 0,
                'income' => $amount,
                'settlement' => $withdraw_count
            );
            return json_encode($result);
        }
        $result = array(
            'status' => -1,
            'message' => '用户未找到或登录已过期！'
        );
        return json_encode($result);
    }
    // 获取总收益 @zhang
    public static function getAllIncome($invite_id) {
        $market_ids = self::getMarketIds($invite_id);
        // 直接下级为空
        if (count($market_ids) == 0) {
            $student_ids = self::getStudentIds($invite_id);
            $orders = OrderInfo::find()
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->all();
            $income = 0;
            foreach ($orders as $order) {
                $income += $order->order_amount;
            }
            return $income * self::INCOMEP;
        } else {
            $student_ids = self::getStudentIds($invite_id);
            $orders = OrderInfo::find()
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->all();
            $income = 0;
            foreach ($orders as $order) {
                $income += $order->order_amount;
            }
            $income = $income * self::INCOMEP;  // 直接订单提成

            // 递归计算子代理金额的提成
            foreach ($market_ids as $key => $market_id) {
                $temp = self::getAllIncome($market_id);
                $income += $temp * self::INCOMENEXTP;
            }
            return $income;
        }
    }
    
    // 获取所有学员id @zhang
    public static function getStudentIds($invite_id) {
        $students = User::find()
        ->where(['invite' => $invite_id])
        ->with(['role' => function($query) {
            $query->where(['item_name' => 'student']);
        }])
        ->all();
        $student_ids = array();
        foreach ($students as $student) {
            if (count($student->role) > 0) {
                $student_ids[] = $student->id;
            }
        }
        return $student_ids;
    }
    // 获取直接下级id @zhang
    public static function getMarketIds($invite_id) {
        $market_ids = array();
        $marketers = User::find()
        ->where(['invite' => $invite_id])
        ->with(['role' => function($query) {
            $query->where(['item_name' => 'marketer']);
        }])
        ->all();
        foreach ($marketers as $key => $marketer) {
            if (count($marketer->role) > 0) {
                $market_ids[] = $marketer->id;
            }
        }
        return $market_ids;
    }
    // 递归计算当前用户的按月统计收益 @zhang
    public static function getMonthIncome($id) {
        $market_ids = self::getMarketIds($id);
        // 直接下级为空
        if (count($market_ids) == 0) {
            $student_ids = self::getStudentIds($id);
            $direct_orders = OrderInfo::find()
            ->select(["sum(order_amount)*".self::INCOMEP." as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])
            ->asArray()
            ->all();
            return $direct_orders;
        } else {
            $student_ids = self::getStudentIds($id);
            $direct_orders = OrderInfo::find()
            ->select(["sum(order_amount)*".self::INCOMEP." as income, DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') as month"])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(['order_status' => 1])->andWhere(['pay_status' => 2])
            ->groupBy(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m') DESC"])
            ->asArray()
            ->all();
            foreach ($market_ids as $key => $market_id) {
                $sub_income = self::getMonthIncome($market_id); // 获取每个子代理的总收益
                foreach ($sub_income as &$income) {
                    $income['income'] = $income['income'] * self::INCOMENEXTP;
                }
                unset($income);
                $direct_orders = array_merge($direct_orders, $sub_income);
                for ($i = 0; $i < count($direct_orders)-1; $i++) {
                    for ($j = $i+1; $j < count($direct_orders); $j++) {
                        if ($direct_orders[$i]['month'] == $direct_orders[$j]['month']) {
                            $direct_orders[$i]['income'] += $direct_orders[$j]['income'] ;
                            unset($direct_orders[$j]);
                            $direct_orders = array_values($direct_orders);
                            $j = $j-1;
                        }
                    }
                }
            }
            return $direct_orders;
        }
    }

    // 按月统计代理的提成收益 @zhang
    public function actionMonthIncome() {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            $my_income = self::getMonthIncome($user->id);
            array_multisort(array_column($my_income,'month'),SORT_DESC,$my_income);
            foreach ($my_income as $key => $item) {
                // 查询每个月的提成是否已经确认提现
                $withdraw_info = Withdraw::find()
                ->where(['user_id' => $user->id, 'withdraw_date' => $my_income[$key]['month']])->one();
                $status_text = '未结算';
                if (!empty($withdraw_info)) {
                    if ($withdraw_info->status === 1) {
                        $status_text = '已结算';
                    } else if ($withdraw_info->status === 0) {
                        $status_text = '申请中';
                    }
                }
                $my_income[$key]['status'] = $status_text;
            }
            $result['status'] = 0;
            $result['my_income'] = $my_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已超时！';
            return json_encode($result);
        }
    }

    /* 查询直接收益明细 @zhang*/
    public function actionDirectIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);
        if (!empty($user)) {
            $direct_income = array();
            $user_array = array();
            // 1、查询直接注册的用户
            $student_ids = self::getStudentIds($user->id);
            // 2、根据直接注册的用户查询邀请的用户下单情况并计算收益
            $orders = OrderInfo::find()
            ->select(['consignee', 'order_amount', 'pay_time', 'user_id'])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->all();
            foreach ($orders as $order) {
                $userpic = User::find()
                ->select(['picture'])
                ->where(['id' => $order->user_id])
                ->one();
                $order_content = array(
                    'pic' => $userpic->picture,
                    'consignee' => $order->consignee,
                    'order_amount' => $order->order_amount,
                    'income' => round($order->order_amount * self::INCOMEP, 2),
                    'pay_time' => date('Y-m-d H:i:s', $order->pay_time)
                );
                $direct_income[] = $order_content;
            }
            array_multisort(array_column($direct_income, 'pay_time'),SORT_DESC, $direct_income);
            $result['status'] = 0;
            $result['direct_income'] = $direct_income;
            return json_encode($result);
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已超时!';
            return json_encode($result);
        }
    }

    /* 按照指定月份查询直接收益明细 @wfzhang */
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
            $student_ids = self::getStudentIds($user->id);
            // 2、根据直接注册的用户查询邀请的用户下单情况并计算收益
            $orders = OrderInfo::find()->select(['consignee', 'order_amount', 'pay_time', 'user_id'])
                ->where(['in', 'user_id', $student_ids])
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
                    'order_amount' => $order->order_amount,
                    'income' => round($order->order_amount * self::INCOMEP, 2),
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

    /* 查询间接收益明细 @wfzhang */
    public function actionIndirectIncome()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $month = $data['month'];
        $result = array();
        $user = User::findIdentityByAccessToken($access_token);

        if (!empty($user)) {
            // 1、查找自己的直接下级代理
            $market_ids = self::getMarketIds($user->id);
            $indirect_income = array();
            foreach ($market_ids as $market_id) {
                $userpic = User::find()
                ->select(['picture', 'username'])
                ->where(['id' => $market_id])
                ->one();
                $income = self::getAllIncome($market_id);
                if ($income > 0) {
                    $item = array(
                        'pic' => $userpic->picture,
                        'username' => $userpic->username,
                        'income' => $income,
                        'tc' => $income * self::INCOMENEXTP
                    );
                    $indirect_income[] = $item;
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

    // 递归计算用户的某一个月份的统计收益 @zhang
    public static function getOneMonthIncome($id, $month) {
        $market_ids = self::getMarketIds($id);
        // 直接下级为空
        if (count($market_ids) == 0) {
            $student_ids = self::getStudentIds($id);
            $direct_orders = OrderInfo::find()
            ->select(["sum(order_amount)*".self::INCOMEP." as income"])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m')" => $month])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->asArray()
            ->all();
            return $direct_orders[0]['income'];
        } else {
            $student_ids = self::getStudentIds($id);
            $direct_orders = OrderInfo::find()
            ->select(["sum(order_amount)*".self::INCOMEP." as income"])
            ->where(['in', 'user_id', $student_ids])
            ->andWhere(["DATE_FORMAT(FROM_UNIXTIME(pay_time, '%Y-%m-%d'), '%Y-%m')" => $month])
            ->andWhere(['order_status' => 1])
            ->andWhere(['pay_status' => 2])
            ->asArray()
            ->all();
            $income = $direct_orders[0]['income'];
            foreach ($market_ids as $key => $market_id) {
                $sub_income = self::getOneMonthIncome($market_id, $month); // 获取每个子代理的总收益
                $income += $sub_income * self::INCOMENEXTP;
            }
            return $income;
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
            $market_ids = self::getMarketIds($user->id);
            $indirect_income = array();
            // 2、查找每个直接下级代理所邀请的学生的订单
            foreach ($market_ids as $market_id) {
                $income = self::getOneMonthIncome($market_id, $month);
                // 3、将订单信息添加到数组并计算该笔订单的间接收益
                $user = User::find()
                ->select(['picture', 'username'])
                ->where(['id' => $market_id])
                ->one();
                if ($income > 0) {
                    $order_content = array(
                        'pic' => $user->picture,
                        'username' => $user->username,
                        'income' => $income,
                        'tc' => $income * self::INCOMENEXTP
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