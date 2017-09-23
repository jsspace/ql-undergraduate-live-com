<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%coupon}}".
 *
 * @property integer $coupon_id
 * @property integer $user_id
 * @property integer $fee
 * @property integer $isuse
 * @property string $start_time
 * @property string $end_time
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coupon}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fee', 'start_time', 'end_time'], 'required'],
            [['user_id', 'fee', 'isuse'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'coupon_id' => Yii::t('app', 'Coupon ID'),
            'user_id' => Yii::t('app', '用户'),
            'fee' => Yii::t('app', '金额'),
            'isuse' => Yii::t('app', '是否使用'),
            'start_time' => Yii::t('app', '开始时间'),
            'end_time' => Yii::t('app', '结束时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return CouponQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CouponQuery(get_called_class());
    }
}
