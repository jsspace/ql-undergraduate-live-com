<?php

namespace common\service;
use backend\models\GoldLog;
use backend\models\GoldLock;
use Yii;

/**
 * Created by PhpStorm.
 * User: caiding
 * Date: 2019/1/19
 * Time: 22:20
 */
class GoldService
{

    public  $operation_detail = [
         '1' => '用户购买金币',
         '2' => '用户推荐好友赠送金币',
         '3' => '用户被推荐赠送金币',
         '4' => '用户注册赠送金币',
         '5' => '用户完成任务奖励金币',
         '-1' => '用户消费金币',
         '-2' => '用户兑换金币'
    ];


    /**
     * 用户更新账户金币信息
     * @param $point 金币个数
     * @param $user_id  用户Id
     * @param $user_type  用户类型
     * @param $operation_type 操作类型
     */

    public  function changeUserGold($point, $user_id, $user_type, $operation_type)
    {
        //校验数据格式
        if(preg_match("/^\d*$/",$point)){
            if($point % 10 != 0){
                //非10的倍数
                return false;
            }
        }else{
            return false;
        }
        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $gold_lock = GoldLock::find()
                ->where(['userid' => $user_id])
                ->all();
            if(!empty($gold_lock)){
                // 已存在交易
                return false;
            }else{
                // 插入锁等待交易完成
                $new_gold_lock = new GoldLock();
                $new_gold_lock->userid = $user_id;
                $new_gold_lock->user_type = $user_type;
                $new_gold_lock->operation_time = time();
                if($new_gold_lock->save()){
                    // 插入新的交易记录
                    $gold_log = new GoldLog();
                    // 获取用户最新的充值记录
                    $old_gold_logs = GoldLog::find()
                        ->where(['userid' => $user_id])
                        ->orderBy('id desc')
                        ->all();
                    if(!empty($old_gold_logs)){
                        $old_balance = $old_gold_logs[0]['balance'];
                        if($operation_type < 0){
                            if($old_balance - $point < 0){
                                return false;
                            }else{
                                $gold_log->gold_balance = $old_balance - $point;
                            }
                        }else{
                            $gold_log->gold_balance = $old_balance + $point;
                        }
                    }else{
                        $gold_log->gold_balance = $point;
                    }
                    $gold_log->userid = $user_id;
                    $gold_log->user_type = $user_type;
                    $gold_log->point = $point;
                    $gold_log->operation_time = time();
                    $gold_log->operation_type = $operation_type;
                    $gold_log->operation_detail = $this->operation_detail[$operation_type.''];
                    if($gold_log -> save()){
                        // 删除锁
                        GoldLock::find()
                            ->where(['userid' => $user_id])
                            ->one()
                            ->delete();
                        $transaction->commit();
                        return true;
                    }else{
                        $transaction->rollBack();
                        return false;
                    }
                }else{
                    return false;
                }
            }
        }catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }

    }

}