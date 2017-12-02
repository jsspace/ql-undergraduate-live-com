<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;


class CardController extends Controller
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
    
    /*金币充值*/
    public function actionIndex()
    {
        return $this->render('index');
    }

}
