<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;


class CommentController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
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
    }*/
    
    
    public function actionIndex()
    {
        
        return $this->render('index');
    }
}
