<?php
namespace frontend\controllers;
header('Content-type:text/json');
use Yii;
use backend\models\Course;
use backend\models\CoursePackage;
use backend\models\HotCategory;
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
use backend\models\CourseCategory;
use backend\models\Comment;

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
                        'actions' => ['signup'],
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
        /*正在直播列表*/
        $course_list = Course::find()
        ->select('id, course_name')
        ->all();
        $chapter_list = CourseChapter::find()
        ->select('id, course_id')
        ->all();
        $sql = 'select * from {{%course_section}} where to_days(start_time) = to_days(now()) and type!=1 ORDER BY start_time ASC';
        $section_list = Yii::$app->db->createCommand($sql)
        ->queryAll();
        $live_ing = array();
        $live_will = array();
        foreach ($course_list as $course) {
            foreach ($chapter_list as $key => $chapter) {
                if ($chapter->course_id == $course->id) {
                    foreach ($section_list as $key => $section) {
                        if ($chapter->id == $section['chapter_id']) {
                            $end_time = date('Y-m-d H:i:s',strtotime($section['start_time']."+".$section['duration']." minute"));
                            $end_simple = date('H:i', strtotime($section['start_time']."+".$section['duration']." minute"));
                            $start_simple = date('H:i', strtotime($section['start_time']));
                            $current_time = date('Y-m-d H:i:s');
                            if ($current_time < $section['start_time']) {
                                $live_will[$section['id']]['course_name'] = $course->course_name.'：'.$section['name'];
                                $live_will[$section['id']]['live_url'] = $section['video_url'];
                                $live_will[$section['id']]['start_time'] = $start_simple;
                                $live_will[$section['id']]['end_time'] = $end_simple;
                                $live_will[$section['id']]['course_id'] = $course->id;
                            } else if ($current_time >= $section['start_time'] && $current_time < $end_time) {
                                $live_ing[$section['id']]['course_name'] = $course->course_name.'：'.$section['name'];
                                $live_ing[$section['id']]['live_url'] = $section['video_url'];
                                $live_ing[$section['id']]['start_time'] = $start_simple;
                                $live_ing[$section['id']]['end_time'] = $end_simple;
                                $live_ing[$section['id']]['course_id'] = $course->id;
                            }
                        }
                    }
                }
            }
        }
        /*直属学院*/
        $colleges = CourseCategory::find()
        ->orderBy('position asc')
        ->limit(7)
        ->all();
        /*课程->热门推荐*/
        $hotcourses = Course::find()
        ->orderBy('view desc')
        ->limit(8)
        ->all();
        /*各大学院*/
        $collegeCourses = Course::find()
        ->all();
        $course_cat = CourseCategory::find()
        ->select('id,name,home_icon')
        ->orderBy('position asc')
        ->all();
        $collegeArr = array();
        foreach ($course_cat as $cat_key => $cat) {
            $collegeArr[$cat->id]["college_name"] = $cat->name;
            $collegeArr[$cat->id]["college_pic"] = $cat->home_icon;
            $count = 0;
            foreach ($collegeCourses as $key => $collegeCourse) {
                if ($count === 8) {
                    break;
                }
                $categoryids = explode(',', $collegeCourse->category_name);
                if (in_array($cat->id, $categoryids)) {
                    $count = $count+1;
                    $collegeArr[$cat->id]['college_course'][$key] = $collegeCourse;
                }
            }
        }
        /*学习感言*/
        $coments = Comment::find()
        ->where(['check' => 1])
        ->limit(6)
        ->all();
        /*友情链接*/
        $flinks = FriendlyLinks::find()
        ->orderBy('position asc')
        ->all();
        /*教师列表*/
        $teachers = User::getUserByrole('teacher');
        return $this->render('index', ['hotcourses' => $hotcourses, "collegeArr" => $collegeArr, 'coments' => $coments, 'flinks' => $flinks, 'teachers' => $teachers, 'live_ing' => $live_ing, 'live_will' => $live_will, 'colleges' => $colleges]);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);
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

        return $this->goHome();
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
                $coupon->fee = 50;
                $coupon->user_id = $user->id;
                $coupon->isuse = 0;
                $coupon->start_time = date('Y-m-d H:i:s', time());
                $coupon->end_time = date('Y-m-d H:i:s', time() + 3*30*24*60*60);
                $coupon->save();
                //如果邀请人是学员，给邀请人添加优惠券
                $roles_model = Yii::$app->authManager->getAssignments($invite);
                if (isset($roles_model['student'])) {
                    $coupon = new Coupon();
                    $coupon->fee = 50;
                    $coupon->user_id = $user->id;
                    $coupon->isuse = 0;
                    $coupon->start_time = date('Y-m-d H:i:s', time());
                    $coupon->end_time = date('Y-m-d H:i:s', time() + 3*30*24*60*60);
                    $coupon->save();
                }
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
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
                    'code' => $code,
                    'expire_time' => time() + 15*3600,
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
        return json_encode($res);
        $err_str = 'login sms code, phone:'. $phone . ' code:' . $code .' ';
        $err_str .= 'time:' . $time .' response:' . json_encode($response);
        error_log($err_str);
      }
    }
}
