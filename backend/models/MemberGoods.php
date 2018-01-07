<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%member_goods}}".
 *
 * @property integer $rec_id
 * @property integer $user_id
 * @property string $order_sn
 * @property integer $member_id
 * @property integer $course_category_id
 * @property string $member_name
 * @property string $price
 * @property string $discount
 * @property integer $add_time
 * @property integer $end_time
 * @property integer $pay_status
 */
class MemberGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'order_sn', 'course_category_id', 'add_time', 'end_time'], 'required'],
            [['user_id', 'member_id', 'course_category_id', 'add_time', 'end_time', 'pay_status'], 'integer'],
            [['price', 'discount'], 'number'],
            [['order_sn'], 'string', 'max' => 200],
            [['member_name'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rec_id' => Yii::t('app', '订单商品信息自增id'),
            'user_id' => Yii::t('app', '用户id'),
            'order_sn' => Yii::t('app', '订单商品信息对应的详细信息id，取值order_info的order_sn'),
            'member_id' => Yii::t('app', '会员id'),
            'course_category_id' => Yii::t('app', '课程分类id'),
            'member_name' => Yii::t('app', '会员名称'),
            'price' => Yii::t('app', '价格'),
            'discount' => Yii::t('app', '折扣价格'),
            'add_time' => Yii::t('app', '购买时间'),
            'end_time' => Yii::t('app', '失效时间'),
            'pay_status' => Yii::t('app', '支付状态；0，未付款；1，付款中；2，已付款'),
        ];
    }

    /**
     * @inheritdoc
     * @return MemberGoodsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemberGoodsQuery(get_called_class());
    }
}
