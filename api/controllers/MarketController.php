<?php
/**
 * Created by PhpStorm.
 * User: DHZ
 * Date: 2019/3/25/025
 * Time: 19:23
 */
namespace api\controllers;

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
                $user_name = $data['username'];     // 用户名
                $phone = $data['phone'];        // 电话号码
                $password = $data['password'];  // 密码
                $g = "/^1[34578]\d{9}$/";
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
                    $marketer_role->save();
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
        $result = array();
        if (!empty($user)) {
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('marketer',$roles_array)) {
                $market_list = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level1']);
                    }])->asArray()->all();
                $result['status'] = 0;
                $result['list'] = $market_list;
                return json_encode($result);

            } else if (array_key_exists('marketer_level1',$roles_array)) {
                $market_list = User::find()->where(['invite' => $user->id])
                    ->with(['role' => function($query) {
                        $query->where(['item_name' => 'marketer_level2']);
                    }])->asArray()->all();
                $result['status'] = 0;
                $result['list'] = $market_list;
                return json_encode($result);

            } else if (array_key_exists('marketer_level2',$roles_array)) {
                $result['status'] = -1;
                $result['message'] = '没有权限添加代理，也没有代理哦！';
                return $result;
            }
        }
        $result['status'] = -1;
        $result['message'] = '用户未找到或登录已过期！';
        return json_encode($result);
    }

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
            foreach ($orders as $order) {
                $income += $order->order_amount;
            }

            // 2、计算间接收益（即自己的下级代理所邀请的学生购课的提成）

            $result['status'] = 0;
            $result['income'] = $income;
            return json_encode($result);
        }
    }
}