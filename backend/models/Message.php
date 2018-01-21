<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property string $msg_id
 * @property integer $publisher
 * @property string $content
 * @property string $classids
 * @property string $cityid
 * @property integer $status
 * @property integer $created_time
 * @property integer $publish_time
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['publisher', 'content'], 'required'],
            [['publisher', 'status', 'created_time', 'publish_time'], 'integer'],
            [['content'], 'string'],
            [['classids'], 'string', 'max' => 255],
            [['cityid'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'msg_id' => Yii::t('app', '消息id'),
            'publisher' => Yii::t('app', '消息发布者'),
            'content' => Yii::t('app', '内容'),
            'classids' => Yii::t('app', '发送给'),
            'cityid' => Yii::t('app', '地级市'),
            'status' => Yii::t('app', '审核状态'),
            'created_time' => Yii::t('app', '消息创建时间'),
            'publish_time' => Yii::t('app', '消息发布时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return MessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessageQuery(get_called_class());
    }
}
