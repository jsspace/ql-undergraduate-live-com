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
        return $this->render('index', ['hotcats' => $hotcats, 'newpcourses' => $newpcourses, 'hotpcourses' => $hotpcourses, 'rankpcourses' => $rankpcourses, 'newcourses' => $newcourses, 'hotcourses' => $hotcourses, 'rankcourses' => $rankcourses, 'tjcourses' => $tjcourses, 'coments' => $coments, 'flinks' => $flinks, 'teachers' => $teachers]);
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
}
