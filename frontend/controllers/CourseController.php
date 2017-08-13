<?php

namespace frontend\controllers;

use yii\web\Controller;


class CourseController extends Controller
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
    
    
    public function actionList()
    {
        return $this->render('list');
    }
    
    public function actionDetail()
    {
        return $this->render('detail');
    }

}
