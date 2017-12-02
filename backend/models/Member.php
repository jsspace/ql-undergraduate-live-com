<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $content
 * @property integer $time_period
 * @property string $price
 * @property string $discount
 * @property integer $course_category_id
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'content', 'time_period', 'price', 'discount', 'course_category_id'], 'required'],
            [['content'], 'string'],
            [['time_period', 'course_category_id'], 'integer'],
            [['price', 'discount'], 'number'],
            [['name'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 600],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '名字'),
            'description' => Yii::t('app', '描述'),
            'content' => Yii::t('app', '详情'),
            'time_period' => Yii::t('app', '有效期'),
            'price' => Yii::t('app', '价格'),
            'discount' => Yii::t('app', '折扣价格'),
            'course_category_id' => Yii::t('app', '课程分类'),
        ];
    }

    /**
     * @inheritdoc
     * @return MemberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemberQuery(get_called_class());
    }
}
