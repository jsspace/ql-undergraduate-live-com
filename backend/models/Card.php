<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%card}}".
 *
 * @property integer $id
 * @property string $card_id
 * @property string $card_pass
 * @property string $money
 * @property integer $create_time
 * @property integer $use_status
 * @property integer $print_status
 * @property integer $use_time
 * @property string $user_phone
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
            [['create_time', 'use_status', 'print_status', 'use_time'], 'integer'],
            [['card_id', 'card_pass'], 'string', 'max' => 100],
            [['user_phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'card_id' => Yii::t('app', '卡号'),
            'card_pass' => Yii::t('app', '学习卡密码'),
            'money' => Yii::t('app', '学习卡金额'),
            'create_time' => Yii::t('app', '创建时间'),
            'use_status' => Yii::t('app', '未使用/已使用'),
            'print_status' => Yii::t('app', '未导出/已导出'),
            'use_time' => Yii::t('app', '使用时间'),
            'user_phone' => Yii::t('app', '使用账号'),
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
