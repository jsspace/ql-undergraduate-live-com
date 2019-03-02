<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%book_order}}".
 *
 * @property string $id
 * @property string $bookid 图书id
 * @property string $userid 预定者id
 * @property int $book_num 预定数量
 * @property string $book_name 图书名
 * @property string $username 预定人姓名
 * @property string $phone 预定人手机号
 * @property string $address 收货地址
 */
class BookOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bookid', 'userid', 'book_num'], 'required'],
            [['bookid', 'userid', 'book_num'], 'integer'],
            [['book_name', 'username', 'phone', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bookid' => Yii::t('app', '图书id'),
            'userid' => Yii::t('app', '预定者id'),
            'book_num' => Yii::t('app', '预定数量'),
            'book_name' => Yii::t('app', '图书名'),
            'username' => Yii::t('app', '预定人姓名'),
            'phone' => Yii::t('app', '预定人手机号'),
            'address' => Yii::t('app', '收货地址'),
        ];
    }

    /**
     * @inheritdoc
     * @return BookOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BookOrderQuery(get_called_class());
    }
}
