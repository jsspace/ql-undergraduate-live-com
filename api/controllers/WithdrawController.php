<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/9/009
 * Time: 17:11
 */

namespace api\controllers;

use backend\models\Withdraw;
use Yii;
use yii\web\Controller;
use common\models\User;
use backend\models\AuthAssignment;


class WithdrawController extends Controller
{
    /* 结算确认 */
    public function actionWithdrawConfirm()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];
        $user = User::findIdentityByAccessToken($access_token);
        $result = array();
        if (!empty($user)) {
            $info = Withdraw::find()->where(['user_id' => $user->id, 'withdraw_date' => $data['month']])->one();
            if (!empty($info)) {
                $result['status'] = -1;
                $result['message'] = '请勿重复提交！';
                return json_encode($result);
            }
            if ($user->alipay_account == '' || $user->alipay_account == null) {
                $result['status'] = -1;
                $result['message'] = '请先绑定支付宝账号！';
                return json_encode($result);
            }
            $user_id = $user->id;
            $fee = $data['salary'];
            $withdraw_date = $data['month'];
            $role_info = AuthAssignment::find()->select(['item_name'])->where(['user_id' => $user->id])->one();
            $withdraw = new Withdraw();
            $withdraw->role = $role_info->item_name;
            $withdraw->user_id = $user_id;
            $withdraw->fee = $fee;
            $withdraw->withdraw_date = $withdraw_date;
            $withdraw->bankc_card = $user->alipay_account;
            $withdraw->bank = '支付宝';
            $withdraw->bank_username = $user->username;
            $withdraw->status = 0;
            $withdraw->create_time = time();
            if ($withdraw->save()) {
                $result['status'] = 0;
                $result['message'] = '确认结算成功！';
                return json_encode($result);
            } else {
                $result['status'] = -1;
                $result['message'] = '确认结算失败，请再次尝试！';
                return json_encode($result);
            }
        } else {
            $result['status'] = -1;
            $result['message'] = '用户未找到或登录已过期！';
            return json_encode($result);
        }
    }
}