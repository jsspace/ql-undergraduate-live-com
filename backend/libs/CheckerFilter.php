<?php
/**
 * Created by PhpStorm.
 * User: jiangyan
 * Date: 2016-05-18
 * Time: 17:22
 */
namespace backend\libs;

use backend\models\AdminSession;
use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;

class CheckerFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        //rbac访问控制
        $controllerID = Yii::$app->controller->id;
        $actionID = $action->id;
        //登录  所有操作都虚经过过滤器控制输出
        if(!Yii::$app->user->isGuest && $actionID != 'logout')
        {
            $id = Yii::$app->user->id;
            $session = Yii::$app->session;
            $username = Yii::$app->user->identity->username;
            $tokenSES = $session->get(md5(sprintf("%s&%s",$id,$username))); //取出session中的用户登录token
            $sessionTBL = AdminSession::findOne(['id' => $id]);
            $tokenTBL = $sessionTBL->session_token;
            if($tokenSES != $tokenTBL)  //如果用户登录在 session中token不同于数据表中token
            {
                Yii::$app->user->logout(); //执行登出操作
                Yii::$app->run();
            }
        }
        return parent::beforeAction($action);
    }
}
