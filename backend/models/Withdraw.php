<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%withdraw}}".
 *
 * @property integer $withdraw_id
 * @property string $role
 * @property integer $user_id
 * @property string $fee
 * @property string $info
 * @property string $withdraw_date
 * @property string $bankc_card
 * @property string $bank
 * @property string $bank_username
 * @property integer $status
 * @property string $create_time
 */
class Withdraw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%withdraw}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'withdraw_date', 'bankc_card', 'bank', 'bank_username', 'status'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['fee'], 'number'],
            [['info'], 'string'],
            [['withdraw_date', 'create_time'], 'safe'],
            [['role'], 'string', 'max' => 200],
            [['bankc_card'], 'string', 'max' => 30],
            [['bank', 'bank_username'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'withdraw_id' => Yii::t('app', 'Withdraw ID'),
            'role' => Yii::t('app', '用户类型'),
            'user_id' => Yii::t('app', '用户'),
            'fee' => Yii::t('app', '金额'),
            'info' => Yii::t('app', '描述信息'),
            'withdraw_date' => Yii::t('app', '提现时间'),
            'bankc_card' => Yii::t('app', '银行卡号'),
            'bank' => Yii::t('app', '银行名称'),
            'bank_username' => Yii::t('app', '户名'),
            'status' => Yii::t('app', '状态'),
            'create_time' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return WithdrawQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WithdrawQuery(get_called_class());
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = date('Y-m-d H:i:s', time());
            }
            return true;
        } else {
            return false;
        }
    }
}
