<?php
namespace frontend\controllers;
header('Content-type:text/json');
use backend\models\GoldLog;
use common\service\GoldService;
use Yii;
use backend\models\Course;
use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ChangePasswordForm;
use frontend\models\SignupForm;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use backend\models\CourseNews;
use backend\models\CourseComent;
use backend\models\FriendlyLinks;
use backend\models\User;
use backend\models\Coupon;
use backend\models\CourseChapter;
use backend\models\CourseSection;
use backend\models\OrderInfo;
use backend\models\Data;
use backend\models\Comment;
use backend\models\Notice;
use backend\models\Message;
use backend\models\Read;
use backend\models\AdminSession;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {

        $currentaction = $action->id;
        $novalidactions = ['video-auth'];
        if(in_array($currentaction,$novalidactions)) {
            $action->controller->enableCsrfValidation = false;
        }
        parent::beforeAction($action);
        return true;
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        /*公告*/
        $notices = Notice::find()
        ->orderBy([
            'position' => SORT_ASC,
            'id' => SORT_DESC,
        ])
        ->all();
        return $this->render('index', ['notices' => $notices]);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        /* 已经登录返回首页 */
        if (!Yii::$app->user->isGuest) {
            if (strstr(Yii::$app->user->returnUrl, 'signup')) {
                return $this->goHome();
            } else {
                return $this->goBack();
            }
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            //使用session和表tbl_admin_session记录登录账号的token:time&id&ip,并进行MD5加密
            $id = Yii::$app->user->id;     //登录用户的ID
            
            $username = Yii::$app->user->identity->username; //登录账号
            $ip = Yii::$app->request->userIP; //登录用户主机IP
            $token = md5(sprintf("%s&%s",$id,$ip));  //将用户ID和IP联合加密成token存入表
            
            $session = Yii::$app->session;
            $session->set(md5(sprintf("%s&%s",$id,$username)),$token);  //将token存到session变量中
            //存session token值没必要取键名为$id&$username ,目的是标识用户登录token的键，$id或$username就可以
            
            $model->insertSession($id,$token);//将token存到tbl_admin_session
            return $this->goHome();
            // if (strstr(Yii::$app->user->returnUrl, 'signup')) {
            //     return $this->goHome();
            // } else {
            //     return $this->goBack();
            // }
        } else {
            //Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goBack();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $invite = Yii::$app->request->get('invite') ? Yii::$app->request->get('invite') : 0;
        $cookies = Yii::$app->response->cookies;
        if (empty($invite) && $cookies->has('invite')) {
            $invite = $cookies['invite'];
        }
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                //给注册学员发优惠券
                $coupon = new Coupon();
                $coupon->name = '新会员50元优惠券';
                $coupon->fee = 50;
                $coupon->user_id = $user->id;
                $coupon->isuse = 0;
                $coupon->start_time = date('Y-m-d H:i:s', time());
                $coupon->end_time = date('Y-m-d H:i:s', time() + 3*30*24*60*60);
                $coupon->save();
                // 赠送学员金币
                $gold_service = new GoldService();
                $user_point = 20;
                //如果邀请人是学员，给邀请人添加优惠券
                if (!empty($invite)) {
                    // 接收邀请再加100金币
                    $user_point = $user_point + 100;
                    $roles_model = Yii::$app->authManager->getAssignments($invite);
                    if (isset($roles_model['student'])) {
                        $coupon = new Coupon();
                        $coupon->name = '推广新会员50元优惠券';
                        $coupon->fee = 50;
                        $coupon->user_id = $invite;
                        $coupon->isuse = 0;
                        $coupon->start_time = date('Y-m-d H:i:s', time());
                        $coupon->end_time = date('Y-m-d H:i:s', time() + 3*30*24*60*60);
                        $coupon->save();
                        // 推荐新人赠送100金币 operation_type = 2
                        $gold_service->changeUserGold(100, $invite, 2);
                    }
                    // 给邀请人发信息
                    $message = new Message();
                    $message->publisher = 1;
                    $message->content = $user->username . "通过你分享的二维码注册了都想学!";
                    $message->classids = $invite;
                    $message->status = 1;
                    $message->publish_time = time();
                    $message->title = '系统消息: 有新人注册啦';
                    if ($message->save()) {
                        $read = new Read();
                        $read->msg_id = $message->msg_id;
                        $read->userid = $invite;
                        $read->status = 0;
                        $read->get_time = time();
                        $read->save();
                    }
                }
                // 新人注册赠送金币 operation_type 3
                $gold_service->changeUserGold($user_point, $invite, 3);
                if (Yii::$app->getUser()->login($user)) {
                    //使用session和表tbl_admin_session记录登录账号的token:time&id&ip,并进行MD5加密
                    $id = Yii::$app->user->id;     //登录用户的ID
                    
                    $username = Yii::$app->user->identity->username; //登录账号
                    $ip = Yii::$app->request->userIP; //登录用户主机IP
                    $token = md5(sprintf("%s&%s",$id,$ip));  //将用户ID和IP联合加密成token存入表
                    
                    $session = Yii::$app->session;
                    $session->set(md5(sprintf("%s&%s",$id,$username)),$token);  //将token存到session变量中
                    //存session token值没必要取键名为$id&$username ,目的是标识用户登录token的键，$id或$username就可以
                    
                    LoginForm::insertSession($id,$token);//将token存到tbl_admin_session
                    //return $this->goHome();
                    return $this->goBack();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'invite' => $invite,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
//     public function actionResetPassword($token)
//     {
//         try {
//             $model = new ResetPasswordForm($token);
//         } catch (InvalidParamException $e) {
//             throw new BadRequestHttpException($e->getMessage());
//         }

//         if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
//             Yii::$app->session->setFlash('success', 'New password saved.');

//             return $this->goHome();
//         }

//         return $this->render('resetPassword', [
//             'model' => $model,
//         ]);
//     }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '新密码已保存。');
            return $this->goHome();
        }
        return $this->render('changePassword', [
            'model' => $model,
        ]);
    }
    
    public function actionChangPasswordCode()
    {
        $phone = Yii::$app->request->Post('phone');
        $is_phone_user_exist = \common\models\User::findByPhone($phone);
        if (empty($is_phone_user_exist)) {
            $res = [
                'status' => 'error',
                'message' => '不存在这个手机号账户！',
            ];
            return json_encode($res);
        }
        
        //检查session是否打开
        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
        }
        $session = Yii::$app->session;
        if (isset($session['change_password_code']) && $session['change_password_code']['request_time'] > time()) {
            $res = [
                'status' => 'error',
                'message' => '请等待' . ($session['change_password_code']['request_time']-time()) . 's后再试。',
            ];
            return json_encode($res);
        } else {
            $code = rand(100000,999999);
            $time = date('Y m d H:i:s', time());
            $response = SmsController::sendSms(
                "优师联考本", // 短信签名
                "SMS_107160030", // 短信模板编号
                $phone, // 短信接收者
                Array(  // 短信模板中字段的值
                    "time" => $time,
                    "code"=>$code,
                    ),
                'change password sms code , phone:' . $phone . ' time:' . $time  // 流水号,选填
                );
    
            $res = [];
            if ($response->Code == 'OK') {
                $smsdata = [
                    'phone' => $phone,
                    'code' => $code,
                    'expire_time' => time() + 15*60,
                    'request_time' => time() + 30,
                ];
                Yii::$app->session->set('change_password_code', $smsdata);
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
            $err_str = 'change password sms code, phone:'. $phone . ' code:' . $code .' ';
            $err_str .= 'time:' . $time .' response:' . json_encode($response);
            error_log($err_str);
            return json_encode($res);
        }
    }
    
    public function actionVideoAuth(){
        $roomid = '';
        $viewername = '';
        $viewertoken = '';
        if (!empty($_POST['roomid'])) {
            $roomid = $_POST['roomid'];
        }
        if (!empty($_POST['viewername'])) {
            $viewername = $_POST['viewername'];
        }
        if (!empty($_POST['viewertoken'])) {
            $viewertoken = $_POST['viewertoken'];
        }
        $user = User::getUserByName($viewername, $viewertoken);
        if (empty($user)) {
            $authorizePlay = array(
                'result' => 'false',
                'message' => '用户名或密码错误',
            );
            return json_encode($authorizePlay);
        }
        $course_ids = '';
        if (!empty($user)) {
            $courseid = CourseSection::getCourse($roomid);
            $order = OrderInfo::find()
            ->select('course_ids')
            ->where(['user_id' => $user->id])
            ->andWhere(['pay_status' => 2])
            ->all();
            //->createCommand()->getRawSql();
            if (!empty($order)) {
                foreach($order as $item) {
                    $course_ids .= $item->course_ids . ',';
                }
            }
            $course_ids_arr = explode(',', $course_ids);
        }
        if (in_array($courseid, $course_ids_arr)) {
            $authorizePlay = array(
                'result' => 'ok',
                'message' => '验证成功',
                'user' => array(
                    'id' => "'".$user->id."'",
                    'name' => $user->username,
                    'avatar' => 'www.kaoben.top/'.$user->picture,
                    )
            );
            /*$result['result'] = 'ok';
            $result['message'] = '验证成功';
            $result['user']['id'] = $user->id;
            $result['user']['name'] = $user->username;
            $result['user']['avatar'] = $user->picture;
            $result['user']['customua'] = 1;
            $result['user']['marquee']['loop'] = -1;
            $result['user']['marquee']['type'] = 'text';
            $result['user']['marquee']['text']['content'] = $user->username;
            $result['user']['marquee']['text']['font_size'] = '12';
            $result['user']['marquee']['text']['color'] = '0xf0f00f';
            $result['user']['marquee']['action'][0]['duration'] = '4000';
            $result['user']['marquee']['action'][0]['start']['xpos'] = 0;
            $result['user']['marquee']['action'][0]['start']['ypos'] = 0;
            $result['user']['marquee']['action'][0]['start']['alpha'] = 0.5;
            $result['user']['marquee']['action'][0]['end']['xpos'] = 1;
            $result['user']['marquee']['action'][0]['end']['ypos'] = 0;
            $result['user']['marquee']['action'][1]['duration'] = '4000';
            $result['user']['marquee']['action'][1]['start']['xpos'] = 1;
            $result['user']['marquee']['action'][1]['start']['ypos'] = 0;
            $result['user']['marquee']['action'][1]['start']['alpha'] = 0.5;
            $result['user']['marquee']['action'][1]['end']['xpos'] = 1;
            $result['user']['marquee']['action'][1]['end']['ypos'] = 1;*/
        } else {
            $authorizePlay = array(
                'result' => 'false',
                'message' => '请先购买该门课程',
            );
        }
        return json_encode($authorizePlay);
    }
    
    public function actionLogincode()
    {
        $phone = Yii::$app->request->Post('phone');
        if (empty($phone)) {
            $res = [
                'status' => 'error',
                'message' => '参数缺失。',
            ];
            return json_encode($res);
        }
        $phone_exist = User::find()
        ->where(['phone' => $phone])
        ->andWhere(['status' => 10])
        ->one();
        if (!empty($phone_exist)) {
            $res = [
                'status' => 'error',
                'message' => '这个手机号已经注册了，请使用另外一个手机号。',
            ];
            return json_encode($res);
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
            return json_encode($res);
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
                'expire_time' => time() + 15*60,
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
        return json_encode($res);
        $err_str = 'login sms code, phone:'. $phone . ' code:' . $code .' ';
        $err_str .= 'time:' . $time .' response:' . json_encode($response);
        error_log($err_str);
      }
    }
}
