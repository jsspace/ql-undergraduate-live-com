<?php

namespace backend\models;
use backend\models\User;
use backend\models\OrderGoods;
use backend\models\read;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property string $msg_id
 * @property integer $publisher
 * @property string $content
 * @property string $title
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
            [['content', 'title'], 'required'],
            [['publisher', 'status', 'created_time', 'publish_time'], 'integer'],
            [['content'], 'string'],
            [['classids', 'title'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', '标题'),
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

    public static function getMessage($msg_id)
    {
        $model = self::find()
        ->where(['msg_id' => $msg_id])
        ->one();
        return $model;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            /* 分割传过来的数组 */
            if($this->classids) {
                if (is_array($this->classids)) {
                    $this->classids = implode(',',$this->classids);
                }
            }
            if ($insert) {
                $this->publisher = Yii::$app->user->id;
                $this->created_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
