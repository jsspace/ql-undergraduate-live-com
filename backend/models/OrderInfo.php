<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%order_info}}".
 *
 * @property integer $order_id
 * @property string $order_sn
 * @property integer $user_id
 * @property integer $order_status
 * @property integer $pay_status
 * @property string $consignee
 * @property string $mobile
 * @property string $email
 * @property string $pay_id
 * @property string $pay_name
 * @property string $goods_amount
 * @property string $pay_fee
 * @property string $money_paid
 * @property integer $integral
 * @property string $integral_money
 * @property string $bonus
 * @property string $order_amount
 * @property integer $add_time
 * @property integer $confirm_time
 * @property integer $pay_time
 * @property integer $bonus_id
 * @property integer $is_separate
 * @property integer $parent_id
 * @property string $discount
 * @property integer $invalid_time
 * @property string $course_ids
 * @property string $coupon_ids
 * @property string $coupon_money
 * @property integer $gift_coins
 * @property string $gift_books
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
            [['order_sn', 'add_time', 'course_ids'], 'required'],
            [['user_id', 'order_status', 'pay_status', 'integral', 'add_time', 'confirm_time', 'bonus_id', 'is_separate', 'parent_id', 'gift_coins'], 'integer'],
            [['goods_amount', 'pay_fee', 'money_paid', 'integral_money', 'bonus', 'order_amount', 'discount', 'coupon_money'], 'number'],
            [['order_sn', 'pay_id', 'course_ids', 'gift_books'], 'string', 'max' => 200],
            [['consignee', 'mobile', 'email'], 'string', 'max' => 60],
            [['pay_name'], 'string', 'max' => 120],
            [['coupon_ids'], 'string', 'max' => 100],
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
            'user_id' => Yii::t('app', '用户'),
            'order_status' => Yii::t('app', '订单状态'),
            'pay_status' => Yii::t('app', '支付状态'),
            'consignee' => Yii::t('app', '用户'),
            'mobile' => Yii::t('app', '收货人的手机，用户页面填写，默认取值于表user_phone'),
            'email' => Yii::t('app', '收货人的邮箱，用户页面填写，默认取值于表user_email'),
            'pay_id' => Yii::t('app', '支付订单号'),
            'pay_name' => Yii::t('app', '支付方式'),
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
            'course_ids' => Yii::t('app', '课程id'),
            'coupon_ids' => Yii::t('app', '优惠券id'),
            'coupon_money' => Yii::t('app', '优惠券金额'),
            'gift_books' => Yii::t('app', '赠送的图书'),
            'gift_coins' => Yii::t('app', '赠送的金币')
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

    private static $_items = array();
    public static function item($status)
    {
        if(!isset(self::$_items[$status]))
            self::loadItems();
            return isset(self::$_items[$status]) ? self::$_items[$status] : false;
    }
    public static function loadItems() {
        self::$_items[0] = '未付款';
        self::$_items[1] = '付款中';
        self::$_items[2] = '已付款';
    }
}
