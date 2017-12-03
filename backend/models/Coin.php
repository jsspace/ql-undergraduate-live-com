<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%coin}}".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $income
 * @property string $balance
 * @property string $operation_detail
 * @property integer $operation_time
 * @property string $card_id
 */
class Coin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'income', 'balance', 'operation_detail', 'operation_time', 'card_id'], 'required'],
            [['userid', 'operation_time'], 'integer'],
            [['income', 'balance'], 'number'],
            [['operation_detail'], 'string'],
            [['card_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userid' => Yii::t('app', '用户id'),
            'income' => Yii::t('app', '收支'),
            'balance' => Yii::t('app', '余额'),
            'operation_detail' => Yii::t('app', '操作明细'),
            'operation_time' => Yii::t('app', '操作时间'),
            'card_id' => Yii::t('app', '学习卡卡号'),
        ];
    }

    /**
     * @inheritdoc
     * @return CoinQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CoinQuery(get_called_class());
    }
}
