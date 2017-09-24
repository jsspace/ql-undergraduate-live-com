<?php

namespace frontend\controllers;

class OrderInfoController extends \yii\web\Controller
{
    public function actionSlcourse()
    {
        return $this->render('slcourse');
    }

    public function actionCart()
    {
        return $this->render('cart');
    }

    public function actionPay()
    {
        return $this->render('pay');
    }

    public function actionPayway()
    {
        return $this->render('payway');
    }
}
