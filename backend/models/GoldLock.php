<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_gold_lock".
 *
 * @property int $id
 * @property int $userid 用户id
 * @property int $user_type 用户类型
 * @property int $operation_time 操作时间
 */
class GoldLock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_gold_lock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'user_type', 'operation_time'], 'required'],
            [['userid', 'user_type', 'operation_time'], 'integer'],
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
            'operation_time' => 'Operation Time',
        ];
    }
}
