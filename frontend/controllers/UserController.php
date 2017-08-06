<?php

namespace frontend\controllers;

use yii\web\Controller;


class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'cache' => [
                'class' => 'yii\filters\PageCache',
                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ],
            ],
        ];
    }
    
    
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionInfo()
    {
        return $this->render('info');
    }

    public function actionEdit()
    {
        return $this->render('edit');
    }

}
