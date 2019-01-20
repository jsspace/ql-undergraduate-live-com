<?php

namespace frontend\controllers;
use backend\models\GoldLog;
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
//             'cache' => [
//                 'class' => 'yii\filters\PageCache',
//                 'duration' => 60,
//                 'variations' => [
//                     \Yii::$app->language,
//                 ],
//             ],
        ];
    }
    public function beforeAction($action)
    {

        $currentaction = $action->id;
        $novalidactions = ['wechat-recharge', 'wechat-get-balance'];
        if(in_array($currentaction,$novalidactions)) {
            $action->controller->enableCsrfValidation = false;
        }
        parent::beforeAction($action);
        return true;
    }
//    public function actionIndex()
//    {
//        $coin = Coin::find()
//        ->where(['userid' => Yii::$app->user->id])
//        ->orderBy('id desc')
//        ->one();
//        if (!empty($coin)) {
//            $balance = $coin->balance;
//        } else {
//            $balance = 0;
//        }
//        return $this->render('index', ['coin_balance' => $balance]);
//    }

    public function actionIndex()
    {
        $gold_log = GoldLog::find()
            ->where(['userid' => Yii::$app->user->id])
            ->orderBy('id desc')
            ->one();
        if (!empty($gold_log)) {
            $gold_balance = $gold_log->gold_balance;
        } else {
            $gold_balance = 0;
        }
        return $this->render('index', ['gold_balance' => $gold_balance]);
    }

    /*充值*/
    public function actionRecharge()
    {
        $result = array();
        $data = Yii::$app->request->post();
        $card_id = $data['card_id'];
        $card_pass = $data['card_pass'];
        //充值卡
        $card_model = Card::find()
        ->where(['card_id' => $card_id])
        ->andWhere(['card_pass' => $card_pass])
        ->one();
        if (empty($card_model)) {
            $result['status'] = 'error';
            $result['message'] = '该学习卡不存在，请认真核对您填写的卡号和密码是否正确';
            return json_encode($result);
        }
        if ($card_model->use_status == 1) {
            $result['status'] = 'error';
            $result['message'] = '学习卡已在'.date('Y-m-d H:m:s', $card_model->use_time).'充值了，不可重复充值';
            return json_encode($result);
        }
        $coin_model = new Coin();
        $coin = Coin::find()
        ->where(['userid' => Yii::$app->user->id])
        ->orderBy('id desc')
        ->one();
        if (!empty($coin)) {
            $balance = $coin->balance;
        } else {
            $balance = 0;
        }
        $coin_model->userid = Yii::$app->user->id;
        $coin_model->income = $card_model->money;
        $coin_model->balance = $card_model->money+$balance;
        $coin_model->operation_detail = '学习卡充值'.$card_model->money.'元';
        $coin_model->operation_time = time();
        $coin_model->card_id = $card_model->card_id;
        if ($coin_model->save()) {
            $card_model->use_status = 1;
            $card_model->use_time = time();
            $user = User::getUserModel(Yii::$app->user->id);
            $card_model->user_phone = $user->phone;
            if ($card_model->save()) {
                $result['status'] = 'success';
                $result['message'] = '学习卡充值成功';
                return json_encode($result);
            }
        }
        $result['status'] = 'error';
        $result['message'] = '学习卡充值失败';
        return json_encode($result);
    }
    public function actionHowto()
    {
        return $this->render('howto');
    }
}
