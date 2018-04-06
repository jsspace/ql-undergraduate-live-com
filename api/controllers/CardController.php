<?php

namespace api\controllers;
use Yii;
use backend\models\Card;
use backend\models\Coin;
use common\models\User;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;

class CardController extends ActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'backend\models\Card';

    /* 过滤器实现认证 */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticatior' => [
                'class' => QueryParamAuth::className()
            ]
        ]);
    }

    /*小程序充值*/
    public function actionWechatRecharge()
    {
        $result = array();
        $data = Yii::$app->request->post();
        $getdata = Yii::$app->request->get();
        $access_token = $getdata['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $user_id = $user->id;
        $card_id = $data['card_id'];
        $card_pass = $data['card_pass'];
        //充值卡
        $card_model = Card::find()
        ->where(['card_id' => $card_id])
        ->andWhere(['card_pass' => $card_pass])
        ->one();
        if (empty($card_model)) {
            $result['status'] = '-1';
            $result['msg'] = '该学习卡不存在，请认真核对您填写的卡号和密码是否正确';
            return $result;
        }
        if ($card_model->use_status == 1) {
            $result['status'] = '-1';
            $result['msg'] = '学习卡已在'.date('Y-m-d H:m:s', $card_model->use_time).'充值了，不可重复充值';
            return $result;
        }
        $coin_model = new Coin();
        $coin = Coin::find()
        ->where(['userid' => $user_id])
        ->orderBy('id desc')
        ->one();
        if (!empty($coin)) {
            $balance = $coin->balance;
        } else {
            $balance = 0;
        }
        $coin_model->userid = $user_id;
        $coin_model->income = $card_model->money;
        $coin_model->balance = $card_model->money+$balance;
        $coin_model->operation_detail = '学习卡充值'.$card_model->money.'元';
        $coin_model->operation_time = time();
        $coin_model->card_id = $card_model->card_id;
        if ($coin_model->save()) {
            $card_model->use_status = 1;
            $card_model->use_time = time();
            $card_model->user_phone = $user->phone;
            if ($card_model->save()) {
                $result['status'] = '200';
                $result['message'] = '学习卡充值成功';
                return $result;
            }
        }
        $result['status'] = 'error';
        $result['message'] = '学习卡充值失败';
        return $result;
    }

    /*获取用户余额*/
    public function actionWechatGetBalance()
    {
        $result = array();
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        //充值卡余额
        $coin = Coin::find()
        ->where(['userid' => $user->id])
        ->orderBy('id desc')
        ->one();
        if (!empty($coin)) {
            $balance = $coin->balance;
        } else {
            $balance = 0;
        }
        $result['status'] = '200';
        $result['balance'] = $balance;
        return $result;
    }
    public function actionCoinDetails()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $coins = Coin::find()
        ->where(['userid' => $user->id])
        ->orderBy('id desc')
        ->all();
        $result = array();
        foreach ($coins as $key => $coin) {
            $content = array(
                'income' => $coin->income,
                'operation_time' => date('Y-m-d H:i:s',$coin->operation_time),
                'operation_detail' => $coin->operation_detail
            );
            $result[] = $content;
        }
        return $result;
    }
}
