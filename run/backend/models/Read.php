<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%read}}".
 *
 * @property string $id
 * @property string $msg_id
 * @property string $userid
 * @property integer $status
 * @property integer $read_time
 * @property integer $get_time
 */
class Read extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%read}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg_id', 'userid', 'get_time'], 'required'],
            [['msg_id', 'userid', 'status', 'read_time', 'get_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'msg_id' => Yii::t('app', '消息id'),
            'userid' => Yii::t('app', '学员'),
            'status' => Yii::t('app', '读取状态'),
            'read_time' => Yii::t('app', '读取消息时间'),
            'get_time' => Yii::t('app', '收到消息时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return ReadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReadQuery(get_called_class());
    }
}
