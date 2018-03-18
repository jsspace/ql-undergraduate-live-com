<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get', 'post'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //使用session和表tbl_admin_session记录登录账号的token:time&id&ip,并进行MD5加密
            $id = Yii::$app->user->id;     //登录用户的ID
            
            $username = Yii::$app->user->identity->username; //登录账号
            $ip = Yii::$app->request->userIP; //登录用户主机IP
            $token = md5(sprintf("%s&%s&%s",time(),$id,$ip));  //将用户登录时的时间、用户ID和IP联合加密成token存入表
            
            $session = Yii::$app->session;
            $session->set(md5(sprintf("%s&%s",$id,$username)),$token);  //将token存到session变量中
            //存session token值没必要取键名为$id&$username ,目的是标识用户登录token的键，$id或$username就可以
            
            $model->insertSession($id,$token);//将token存到tbl_admin_session
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
