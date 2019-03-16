<?php
namespace common\service;
use common\models\User;
use backend\models\OrderInfo;
use Yii;

class PersonalService {
    public function countIncome($date,$data2,$userid) {
        $users = User::find()
        ->where(['invite' => $userid])
        ->all();
        $user_array=array();
        foreach ($users as $key => $usersingle) {
            $user_array[] = $usersingle->id;
        }
        $orders = OrderInfo::find()
        ->where(['in', 'user_id', $user_array])
        ->andWhere(['order_status' => 1])
        ->andWhere(['pay_status' => 2])
        ->andWhere(['>','pay_time' , $date])
        ->andWhere(['<','pay_time' , $data2])
        ->all();
        // return ($orders);
        $income = 0;
            foreach ($orders as $key => $order) {
                $income += $order->order_amount;
            }
        return  ($income);
    }
}