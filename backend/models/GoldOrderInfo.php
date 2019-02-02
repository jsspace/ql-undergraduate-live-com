<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_gold_order_info".
 *
 * @property string $order_id 订单详细信息自增id
 * @property string $order_sn 订单号，唯一
 * @property string $user_id 用户id，同ecs_users的user_id
 * @property string $gold_num 用户购买金币数量
 * @property int $order_status 订单状态。0，未确认；1，已确认；2，已取消；3，无效；4，退货；
 * @property int $pay_status 支付状态；0，未付款；1，付款中；2，已付款
 * @property string $pay_id 支付订单号
 * @property string $pay_name 用户选择的支付方式的名称，取值表ecs_payment
 * @property string $pay_fee 支付费用,跟支付方式的配置相关，取值表ecs_payment
 * @property string $money_paid 已付款金额
 * @property string $order_amount 应付款金额
 * @property int $add_time 订单生成时间
 * @property int $confirm_time 订单确认时间
 * @property int $pay_time 订单支付时间
 * @property int $invalid_time 失效时间
 * @property int $gift_coins 赠送的金币
 */
class GoldOrderInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_gold_order_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn', 'add_time'], 'required'],
            [['user_id', 'gold_num', 'add_time', 'confirm_time', 'pay_time', 'invalid_time', 'gift_coins'], 'integer'],
            [['pay_fee', 'money_paid', 'order_amount'], 'number'],
            [['order_sn', 'pay_id'], 'string', 'max' => 200],
            [['order_status', 'pay_status'], 'string', 'max' => 1],
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
            'order_id' => 'Order ID',
            'order_sn' => 'Order Sn',
            'user_id' => 'User ID',
            'gold_num' => 'Gold Num',
            'order_status' => 'Order Status',
            'pay_status' => 'Pay Status',
            'pay_id' => 'Pay ID',
            'pay_name' => 'Pay Name',
            'pay_fee' => 'Pay Fee',
            'money_paid' => 'Money Paid',
            'order_amount' => 'Order Amount',
            'add_time' => 'Add Time',
            'confirm_time' => 'Confirm Time',
            'pay_time' => 'Pay Time',
            'invalid_time' => 'Invalid Time',
            'gift_coins' => 'Gift Coins',
        ];
    }
}
