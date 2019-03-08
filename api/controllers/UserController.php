<?php

namespace api\controllers;

use yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use api\models\ApiLoginForm;
use api\models\ApiSignupForm;
use api\models\ApiChangePasswordForm;
use backend\models\Coupon;
use backend\models\User;
use backend\models\GoldLog;
use frontend\controllers\SmsController;
use api\models\Smsdata;
use common\controllers\ApiController;
use common\service\GoldService;
/**
 * AudioController implements the CRUD actions for Audio model.
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function actionLogin()
    {
        $model = new ApiLoginForm();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->login()) {
            return ['access_token' => $model->login()];
        } else {
            $model->validate();
            return $model;
        }
    }
    public function actionSignup()
    {
        $model = new ApiSignupForm();

        $model->load($data = Yii::$app->getRequest()->getBodyParams(), '');//实例化对象

        if ($user = $model->signup()) {
            //给注册学员金币
            $gold_service = new GoldService();
            $gold_service->changeUserGold(100,$user->id,4);
            //如果邀请人是学员，给邀请人添加优惠券
            if (!empty($data['invite'])) {
                $roles_model = Yii::$app->authManager->getAssignments($data['invite']);
                if (isset($roles_model['student'])) {
                    $coupon = new Coupon();
                    $coupon->name = '推广新会员50元优惠券';
                    $coupon->fee = 50;
                    $coupon->user_id = $data['invite'];
                    $coupon->isuse = 0;
                    $coupon->start_time = date('Y-m-d H:i:s', time());
                    $coupon->end_time = date('Y-m-d H:i:s', time() + 3*30*24*60*60);
                    $coupon->save();
                }
            }
            return ['status' => '200', 'result' => '注册成功！'];
        } else {
            $model->validate();
            return $model;
        }
    }
    public function actionLogincode()
    {
       $phone = Yii::$app->request->Post('phone');
       if (empty($phone)) {
            $res = [
                'status' => 'error',
                'message' => '电话号码不能为空',
            ];
            return $res;
       }
       $channel = Yii::$app->request->Post('channel');
       if (!empty($channel) && $channel == 'signup') {
           $phone_exist = User::find()
            ->where(['phone' => $phone])
            ->andWhere(['status' => 10])
            ->one();
            if (!empty($phone_exist)) {
                $res = [
                    'status' => 'error',
                    'message' => '手机号已注册，请直接登录',
                ];
                return $res;
            }
        }
        $login_info = Smsdata::find()
        ->where(['phone' => $phone])
        ->one();
        if (!empty($login_info) && $login_info->request_time > time()) {
            $res = [
                'status' => 'error',
                'message' => '请等待' . ($login_info->request_time-time()) . 's后再试。',
            ];
            return $res;
        } else {
        $code = rand(100000,999999);
        $time = date('Y m d H:i:s', time());
        $response = SmsController::sendSms(
            "优师联考本", // 短信签名
            "SMS_107160031", // 短信模板编号
            $phone, // 短信接收者
            Array(  // 短信模板中字段的值
                "time" => $time,
                "code"=>$code,
                ),
            'login sms code , phone:' . $phone . ' time:' . $time  // 流水号,选填
            );
        
        $res = [];
        if ($response->Code == 'OK') {
            if (empty($login_info)) {
                $login_info = new Smsdata();
            }
            $login_info->phone = $phone;
            $login_info->code = $code;
            $login_info->expire_time = time() + 15*60;
            $login_info->request_time = time() + 30;
            $login_info->save();
            $res = [
                'status' => 'success',
                'code' => 0,
                'message' => '短信验证码发送成功',
            ];
        } elseif ($response->Code == 'isv.BUSINESS_LIMIT_CONTROL') {
            $res = [
                'status' => 'error',
                'code' => 1,
                'message' => '短信验证码请求太频繁，请稍后再尝试。同一个手机号码发送短信验证码，支持1条/分钟，5条/小时 ，累计10条/天。',
            ];
        }
        return $res;
        $err_str = 'login sms code, phone:'. $phone . ' code:' . $code .' ';
        $err_str .= 'time:' . $time .' response:' . json_encode($response);
        error_log($err_str);
      }
    }
    public function actionChangepassword()
    {
        $model = new ApiChangePasswordForm();
        $model->load($data = Yii::$app->getRequest()->getBodyParams(), '');//实例化对象
        if ($model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '新密码已保存。');
            return ['status' => '200', 'result' => '密码修改成功！'];
        } else {
            $model->validate();
            return $model;
        }
    }
    public function actionIslogin()
    {
        $get = Yii::$app->request->get();
        $access_token = $get['access-token'];
        $user = \common\models\User::findIdentityByAccessToken($access_token);
        if (empty($user)) {
            $result = array(
                'status' => 0,
                'message' => '未登录'
            );
        } else {
            $gold = GoldLog::find()
            ->where(['userid' => $user->id])
            ->orderBy('operation_time desc')
            ->one();
            if (empty($gold)) {
                $balance = 0;
            } else {
                $balance = $gold->gold_balance;
            }
            $result = array(
                'status' => 1,
                'message' => '已登录',
                'user' => array(
                    'username' => $user->username,
                    'userid' => $user->id,
                    'gold' => $balance
                )
            );
        }
        return $result;
    }
    public function actionOnlogin($code)
    {
        $url = sprintf(Yii::$app->params['wxpay']['jscode2session_url'], $code);
        $response_str = ApiController::http_get_data($url);
        return $response_str;
    }
    // 用户回答问题扣除金币
    public function actionReduceGold() {
        $post = Yii::$app->request->post();
        $access_token = $post['access-token'];
        $user = \common\models\User::findIdentityByAccessToken($access_token);
        if (empty($user)) {
            $result = array(
                'status' => -1,
                'message' => '用户不存在'
            );
        } else {
            if (!empty($post['gold'])) {
                $point = $post['gold'];
                $user_id = $user->id;
                $gold_service = new GoldService();
                $gold_service->changeUserGold($point, $user_id, -1);
                $gold = GoldLog::find()
                ->where(['userid' => $user->id])
                ->orderBy('operation_time desc')
                ->one();
                if (empty($gold)) {
                    $balance = 0;
                } else {
                    $balance = $gold->gold_balance;
                }
                $result = array(
                    'status' => 0,
                    'message' => '金币扣除成功',
                    'gold' => $balance
                );
            } else {
                $result = array(
                    'status' => -2,
                    'message' => '金币数量不能为空'
                );
            }
        }
        return $result;
    }
}
