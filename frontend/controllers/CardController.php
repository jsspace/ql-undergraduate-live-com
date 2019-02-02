<?php

namespace frontend\controllers;
use backend\models\GoldLog;
use common\service\GoldService;
use Yii;
use yii\web\Controller;
use backend\models\Card;
use backend\models\Coin;
use backend\models\User;
use yii\web\NotFoundHttpException;

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
            $gold_balance = intval($gold_log->gold_balance);
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


    public function actionBuy()
    {
        $post = Yii::$app->request->Post();
        //唯一订单号码（KB-YYYYMMDDHHIISSNNNNNNNNCC）
        $order_sn = $this->createOrderid();
        $display = 1;
        $goldNum = $post['gold_num'];
        // 校验金额是否是10的倍数
        $isTen = $goldNum % 10;
        if($isTen != 0){
            return $this->render('gold-order', [
                'error' => '金币填写有误，请重新填写',
            ]);
        }
        $money = $goldNum / 10;
        return $this->render('goldOrder', [
            'money' => $money,
            'gold_num' => $goldNum,
            'order_sn' => $order_sn,
        ]);
    }



    public static function createOrderid()
    {
        //生成24位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-CC，其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数，CC=检查码
        //订购日期
        $order_date = date('Y-m-d');
        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
        $order_id_main = date('YmdHis') . rand(10000000,99999999);
        //订单号码主体长度
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for($i=0; $i<$order_id_len; $i++){
            $order_id_sum += (int)(substr($order_id_main,$i,1));
        }
        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
        $order_sn = 'KB-' . $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);
        return $order_sn;
    }
}
