<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%card}}".
 *
 * @property string $card_id
 * @property string $card_pass
 * @property string $money
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id', 'card_pass', 'money'], 'required'],
            [['money'], 'number'],
            [['card_id', 'card_pass'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'card_id' => Yii::t('app', '序列号'),
            'card_pass' => Yii::t('app', '学习卡密码'),
            'money' => Yii::t('app', '学习卡金额'),
        ];
    }

    /**
     * @inheritdoc
     * @return CardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CardQuery(get_called_class());
    }
}
