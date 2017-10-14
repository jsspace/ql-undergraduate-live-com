<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%order_info}}".
 *
 * @property string $order_id
 * @property string $order_sn
 * @property string $user_id
 * @property integer $order_status
 * @property integer $pay_status
 * @property string $consignee
 * @property string $mobile
 * @property string $email
 * @property integer $pay_id
 * @property string $pay_name
 * @property string $goods_amount
 * @property string $pay_fee
 * @property string $money_paid
 * @property string $integral
 * @property string $integral_money
 * @property string $bonus
 * @property string $order_amount
 * @property string $add_time
 * @property string $confirm_time
 * @property string $pay_time
 * @property integer $bonus_id
 * @property integer $is_separate
 * @property string $parent_id
 * @property string $discount
 * @property string $invalid_time
 */
class OrderInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn', 'consignee', 'mobile', 'email', 'pay_name', 'discount', 'invalid_time'], 'required'],
            [['user_id', 'order_status', 'pay_status', 'pay_id', 'integral', 'add_time', 'confirm_time', 'pay_time', 'bonus_id', 'is_separate', 'parent_id', 'invalid_time'], 'integer'],
            [['goods_amount', 'pay_fee', 'money_paid', 'integral_money', 'bonus', 'order_amount', 'discount'], 'number'],
            [['order_sn'], 'string', 'max' => 20],
            [['consignee', 'mobile', 'email'], 'string', 'max' => 60],
            [['pay_name'], 'string', 'max' => 120],
            [['order_sn'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app', '订单详细信息自增id'),
            'order_sn' => Yii::t('app', '订单号，唯一'),
            'user_id' => Yii::t('app', '用户id，同ecs_users的user_id'),
            'order_status' => Yii::t('app', '订单状态。0，未确认；1，已确认；2，已取消；3，无效；4，退货；'),
            'pay_status' => Yii::t('app', '支付状态；0，未付款；1，付款中；2，已付款'),
            'consignee' => Yii::t('app', '收货人的姓名，用户页面填写，默认取值于表user_address'),
            'mobile' => Yii::t('app', '收货人的手机，用户页面填写，默认取值于表user_phone'),
            'email' => Yii::t('app', '收货人的邮箱，用户页面填写，默认取值于表user_email'),
            'pay_id' => Yii::t('app', '用户选择的支付方式的id，取值表ecs_payment'),
            'pay_name' => Yii::t('app', '用户选择的支付方式的名称，取值表ecs_payment'),
            'goods_amount' => Yii::t('app', '商品总金额'),
            'pay_fee' => Yii::t('app', '支付费用,跟支付方式的配置相关，取值表ecs_payment'),
            'money_paid' => Yii::t('app', '已付款金额'),
            'integral' => Yii::t('app', '使用的积分的数量，取用户使用积分，商品可用积分，用户拥有积分中最小者'),
            'integral_money' => Yii::t('app', '使用积分金额'),
            'bonus' => Yii::t('app', '使用红包金额'),
            'order_amount' => Yii::t('app', '应付款金额'),
            'add_time' => Yii::t('app', '订单生成时间'),
            'confirm_time' => Yii::t('app', '订单确认时间'),
            'pay_time' => Yii::t('app', '订单支付时间'),
            'bonus_id' => Yii::t('app', '红包的id，ecs_user_bonus的bonus_id'),
            'is_separate' => Yii::t('app', '0，未分成或等待分成；1，已分成；2，取消分成；'),
            'parent_id' => Yii::t('app', '能获得推荐分成的用户id，id取值于表ecs_users'),
            'discount' => Yii::t('app', '折扣金额'),
            'invalid_time' => Yii::t('app', '失效时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return OrderInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderInfoQuery(get_called_class());
    }
}