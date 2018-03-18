<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%command}}".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $content
 * @property integer $ischeck
 * @property integer $create_time
 */
class Command extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%command}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'content'], 'required'],
            [['user_id', 'ischeck', 'create_time'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', '学员'),
            'content' => Yii::t('app', '需求'),
            'ischeck' => Yii::t('app', '状态	'),
            'create_time' => Yii::t('app', '时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return CommandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommandQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
