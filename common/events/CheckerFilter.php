<?php
namespace common\events;

use Yii;
use yii\web\session;
use yii\base\Event;
use backend\models\AdminSession;

class CheckerFilter extends Event
{
    public static function login_check()
    {
        //rbac访问控制
        $controllerID = Yii::$app->controller->id;
        $actionID = Yii::$app->controller->action->id;;
        //登录  所有操作都虚经过过滤器控制输出
        if(!Yii::$app->user->isGuest && $actionID != 'logout')
        {
            $id = Yii::$app->user->id;
            $session = Yii::$app->session;
            $username = Yii::$app->user->identity->username;
            $tokenSES = $session->get(md5(sprintf("%s&%s",$id,$username))); //取出session中的用户登录token
            $sessionTBL = AdminSession::findOne(['id' => $id]);
            $tokenTBL = $tokenSES;
            if (!empty($sessionTBL)) {
                $tokenTBL = $sessionTBL->session_token;
            }
            if($tokenSES != $tokenTBL)  //如果用户登录在 session中token不同于数据表中token
            {
                Yii::$app->user->logout(); //执行登出操作
                Yii::$app->run();
            }
        }
    }
}
