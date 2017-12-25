<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%withdraw}}".
 *
 * @property integer $withdraw_id
 * @property integer $user_id
 * @property string $fee
 * @property string $info
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
            [['user_id'], 'integer'],
            [['fee'], 'number'],
            [['info'], 'string'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'withdraw_id' => Yii::t('app', 'Withdraw ID'),
            'user_id' => Yii::t('app', '市场专员'),
            'fee' => Yii::t('app', '金额'),
            'info' => Yii::t('app', '描述信息'),
            'create_time' => Yii::t('app', '提现时间'),
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
