<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Data;


class AboutController extends Controller
{
    /**
     * @inheritdoc
     */
    
    public function actionHowToStudy()
    {
        return $this->render('how-to-study');
    }

}
