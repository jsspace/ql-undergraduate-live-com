<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_gold_log".
 *
 * @property int $id
 * @property int $userid 用户id
 * @property int $user_type 用户类型
 * @property string $point 金币个数
 * @property string $gold_balance 余额
 * @property int $operation_type 操作类型
 * @property string $operation_detail 操作明细
 * @property int $operation_time 操作时间
 */
class GoldLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_gold_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'user_type', 'point', 'gold_balance', 'operation_type', 'operation_detail', 'operation_time'], 'required'],
            [['userid', 'user_type', 'operation_type', 'operation_time'], 'integer'],
            [['point', 'gold_balance'], 'number'],
            [['operation_detail'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'user_type' => 'User Type',
            'point' => 'Point',
            'gold_balance' => 'Gold Balance',
            'operation_type' => 'Operation Type',
            'operation_detail' => 'Operation Detail',
            'operation_time' => 'Operation Time',
        ];
    }
}
