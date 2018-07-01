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

    // 渲染如何学习静态页
    public function actionHowToStudy() {
        return $this->render('how-to-study');
    }

    // 渲染关于我们静态页
    public function actionIndex() {
        return $this->render('index');
    }

    // 加入我们静态页渲染
    public function actionJoin() {
        return $this->render('join');
    }
}
