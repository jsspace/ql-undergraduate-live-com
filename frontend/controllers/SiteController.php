<?php
namespace frontend\controllers;

use Yii;
use backend\models\Course;
use backend\models\CoursePackage;
use backend\models\HotCategory;
use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
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
        $sql = 'select * from {{%course_section}} where to_days(start_time) = to_days(now()) and type = 0 ORDER BY start_time ASC';
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
                                $live_will[$section['id']]['course_name'] = $course->course_name;
                                $live_will[$section['id']]['live_url'] = $section['video_url'];
                                $live_will[$section['id']]['start_time'] = $start_simple;
                                $live_will[$section['id']]['end_time'] = $end_simple;
                                $live_will[$section['id']]['course_id'] = $course->id;
                            } else if ($current_time >= $section['start_time'] && $current_time < $end_time) {
                                $live_ing[$section['id']]['course_name'] = $course->course_name;
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
        /*热门分类*/
        $hotcats = HotCategory::find()
        ->orderBy('position asc')
        ->limit(7)
        ->all();
        /*套餐->最新课程*/
        $courseps = CoursePackage::find();
        $newpcourses = $courseps
        ->orderBy('create_time desc')
        ->limit(8)
        ->all();
        /*套餐->热门推荐*/
        $hotpcourses = $courseps
        ->orderBy('view desc')
        ->limit(8)
        ->all();
        /*套餐->课程排行*/
        $rankpcourses = $courseps
        ->orderBy('online desc')
        ->limit(8)
        ->all();
        /*课程->最新课程*/
        $courses = Course::find();
        $newcourses = $courses
        ->orderBy('create_time desc')
        ->limit(8)
        ->all();
        /*课程->热门推荐*/
        $hotcourses = $courses
        ->orderBy('view desc')
        ->limit(8)
        ->all();
        /*课程->课程排行*/
        $rankcourses = $courses
        ->orderBy('online desc')
        ->limit(8)
        ->all();
        /*软文推荐*/
        $tjcourses = CourseNews::find()
        ->orderBy('position asc')
        ->where(['onuse' => 1])
        ->limit(6)
        ->all();
        /*用户评说*/
        $coments = CourseComent::find()
        ->where(['check' => 1])
        ->orderBy('star desc')
        ->limit(6)
        ->all();
        /*友情链接*/
        $flinks = FriendlyLinks::find()
        ->orderBy('position asc')
        ->all();
        /*教师列表*/
        $teachers = User::getUserByrole('teacher');
        /*资料*/
        $course_datas = Data::find()
        ->orderBy('ctime desc')
        ->limit(6)
        ->all();
        return $this->render('index', ['hotcats' => $hotcats, 'newpcourses' => $newpcourses, 'hotpcourses' => $hotpcourses, 'rankpcourses' => $rankpcourses, 'newcourses' => $newcourses, 'hotcourses' => $hotcourses, 'rankcourses' => $rankcourses, 'tjcourses' => $tjcourses, 'coments' => $coments, 'flinks' => $flinks, 'teachers' => $teachers, 'live_ing' => $live_ing, 'live_will' => $live_will, 'course_datas' => $course_datas]);
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
        $invite = Yii::$app->request->get('id') ? Yii::$app->request->get('id') : 0;
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
                $roles_model = Yii::$app->authManager->getAssignments($uid);
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
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionVideoAuth(){
        $result = array();
        /*$user = User::getUserModel(Yii::$app->user->id);
        $username = $_POST['roomid'];
        $roomid = $_POST['roomid'];
        $courseid = CourseSection::getCourse($roomid);
        $order = OrderInfo::find()
        ->select('course_ids')
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 2])
        ->all();
        //->createCommand()->getRawSql();
        $course_ids = '';
        if (!empty($order)) {
            foreach($order as $item) {
                $course_ids .= $item->course_ids . ',';
            }
        }
        $course_ids_arr = explode(',', $course_ids);
        if (Yii::$app->user->isGuest) {
            $result['result'] = 'false';
            $result['message'] = '请先登录';
        } else if (in_array($courseid, $course_ids_arr)) {
            $result['result'] = 'false';
            $result['message'] = '请先购买';
        } else {
            $result['result'] = 'ok';
            $result['message'] = '认证成功';
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
            $result['user']['marquee']['action'][1]['end']['ypos'] = 1;
        }*/
        $roomid = '';
        $viewername = '';
        if (!empty($_POST['roomid'])) {
            $roomid = $_POST['roomid'];
        }
        if (!empty($_POST['viewername'])) {
            $viewername = $_POST['viewername'];
        }
        error_log('roomid==='.$roomid.'~~~~~~登陆用户名==='.$viewername);
        $result['result'] = 'ok';
        $result['message'] = '认证成功';
        $result['user']['id'] = 'E6A232B2DEDF69469C33DC5901307461';
        $result['user']['name'] = '学员A';
        $result['user']['avatar'] = '';
        $result = json_encode($result);
        return $result;
    }
}
