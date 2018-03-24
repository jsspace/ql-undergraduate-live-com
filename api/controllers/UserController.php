<?php

namespace api\controllers;

use yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use api\models\ApiLoginForm;
use api\models\ApiSignupForm;

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

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');//实例化对象

        if ($model->signup()) {
            return ['status' => '200', 'result' => '注册成功！'];
        } else {
            $model->validate();
            return $model;
        }
    }
}
