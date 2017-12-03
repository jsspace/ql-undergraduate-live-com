<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Card;
use backend\models\Coin;
use backend\models\User;

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
    public function actionIndex()
    {
        return $this->render('index');
    }
    /*充值*/
    public function actionRecharge()
    {
        $data = Yii::$app->request->post();
        $card_id = $data['card_id'];
        $card_pass = $data['card_pass'];
        //充值卡
        $card_model = Card::find()
        ->where(['card_id' => $card_id])
        ->andWhere(['card_pass' => $card_pass])
        ->one();
        $coin_model = new Coin();
        $coin = Coin::find()
        ->where(['userid' => Yii::$app->user->id])
        ->orderBy('id desc')
        ->one();
        $result = array();
        $coin_model->userid = Yii::$app->user->id;
        $coin_model->income = $card_model->money;
        $coin_model->balance = $card_model->money+$coin->balance;
        $coin_model->operation_detail = '学习卡充值'.$card_model->money.'元';
        $coin_model->operation_time = time();
        if ($coin_model->save()) {
            $card_model->use_status = 1;
            $card_model->use_time = time();
            $user = User::getUserModel(Yii::$app->user->id);
            $card_model->user_phone = $user->phone;
            if ($card_model->save()) {
                $result['status'] = 'success';
                $result['message'] = '金币充值成功';
                return $result;
            }
        }
        $result['status'] = 'error';
        $result['message'] = '金币充值失败';
        return $result;
    }
}
