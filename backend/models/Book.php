<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%book}}".
 *
 * @property string $id
 * @property string $name 书名
 * @property string $price 价格
 * @property string $publisher 出版社
 * @property int $publish_time 出版时间
 * @property string $author 作者
 * @property string $category 类别
 * @property string $intro 简介
 * @property string $des 详情
 * @property string $pictrue 封面图片
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['publish_time', 'category'], 'integer'],
            [['intro', 'des'], 'required'],
            [['intro', 'des'], 'string'],
            [['name', 'publisher', 'author', 'pictrue'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '书名'),
            'price' => Yii::t('app', '价格'),
            'publisher' => Yii::t('app', '出版社'),
            'publish_time' => Yii::t('app', '出版时间'),
            'author' => Yii::t('app', '作者'),
            'category' => Yii::t('app', '类别'),
            'intro' => Yii::t('app', '简介'),
            'des' => Yii::t('app', '详情'),
            'pictrue' => Yii::t('app', '封面图片'),
        ];
    }

    /**
     * @inheritdoc
     * @return BookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BookQuery(get_called_class());
    }
}
