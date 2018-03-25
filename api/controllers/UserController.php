<?php

namespace api\controllers;

use yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use api\models\ApiLoginForm;
use api\models\ApiSignupForm;
use backend\models\Coupon;
use backend\models\User;
use frontend\controllers\SmsController;
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
            //给注册学员发优惠券
            $coupon = new Coupon();
            $coupon->fee = 50;
            $coupon->user_id = $user->id;
            $coupon->isuse = 0;
            $coupon->start_time = date('Y-m-d H:i:s', time());
            $coupon->end_time = date('Y-m-d H:i:s', time() + 3*30*24*60*60);
            $coupon->save();
            //如果邀请人是学员，给邀请人添加优惠券
            if (!empty($data['invite'])) {
                $roles_model = Yii::$app->authManager->getAssignments($data['invite']);
                if (isset($roles_model['student'])) {
                    $coupon = new Coupon();
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
       $phone_exist = User::find()
        ->where(['phone' => $phone])
        ->andWhere(['status' => 10])
        ->one();
        if (!empty($phone_exist)) {
            $res = [
                'status' => 'error',
                'message' => '这个手机号已经注册了，请使用另外一个手机号。',
            ];
            return $res;
        }
        //检查session是否打开
        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
        }
        $session = Yii::$app->session;
        if (isset($session['login_sms_code']) && $session['login_sms_code']['request_time'] > time()) {
            $res = [
                'status' => 'error',
                'message' => '请等待' . ($session['login_sms_code']['request_time']-time()) . 's后再试。',
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
            $smsdata = [
                'phone' => $phone,
                'code' => $code,
                'expire_time' => time() + 15*3600,
                'request_time' => time() + 30,
            ];
            Yii::$app->session->set('login_sms_code', $smsdata);
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
}
