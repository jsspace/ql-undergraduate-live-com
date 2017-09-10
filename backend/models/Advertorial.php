<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%advertorial}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property string $pic
 * @property string $content
 * @property string $src
 * @property integer $create_time
 * @property integer $read_num
 */
class Advertorial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertorial}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type', 'pic'], 'required'],
            [['type', 'create_time', 'read_num'], 'integer'],
            [['content'], 'string'],
            [['title', 'pic', 'src'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '软文题目'),
            'type' => Yii::t('app', '软文类别，外链or内部软文'),
            'pic' => Yii::t('app', '软文的开头图片'),
            'content' => Yii::t('app', '软文内容编辑'),
            'src' => Yii::t('app', '外链链接地址'),
            'create_time' => Yii::t('app', '软文创建时间'),
            'read_num' => Yii::t('app', '软文已阅读的人的数量'),
        ];
    }

    /**
     * @inheritdoc
     * @return AdvertorialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertorialQuery(get_called_class());
    }
}
