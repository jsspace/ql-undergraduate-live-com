<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%member_order}}".
 *
 * @property integer $order_id
 * @property string $order_sn
 * @property integer $user_id
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
 * @property string $order_amount
 * @property integer $add_time
 * @property integer $end_time
 * @property integer $pay_time
 * @property string $discount
 * @property integer $invalid_time
 * @property string $member_id
 */
class MemberOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn', 'member_id'], 'required'],
            [['user_id', 'order_status', 'pay_status', 'pay_id', 'add_time', 'end_time', 'pay_time', 'invalid_time'], 'integer'],
            [['goods_amount', 'pay_fee', 'money_paid', 'order_amount', 'discount'], 'number'],
            [['order_sn', 'member_id'], 'string', 'max' => 200],
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
            'order_amount' => Yii::t('app', '应付款金额'),
            'add_time' => Yii::t('app', '添加时间'),
            'end_time' => Yii::t('app', '会员失效时间'),
            'pay_time' => Yii::t('app', '订单支付时间'),
            'discount' => Yii::t('app', '折扣金额'),
            'invalid_time' => Yii::t('app', '失效时间'),
            'member_id' => Yii::t('app', '会员类型id'),
        ];
    }

    /**
     * @inheritdoc
     * @return MemberOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemberOrderQuery(get_called_class());
    }
}
