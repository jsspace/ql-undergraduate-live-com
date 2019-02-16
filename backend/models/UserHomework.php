<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%user_homework}}".
 *
 * @property int $id
 * @property int $course_id 对应课程id
 * @property int $section_id 节次id
 * @property string $pic_url 提交作业图片url
 * @property int $status 状态
 * @property string $submit_time 提交时间
 * @property int $user_id 用户id
 */
class UserHomework extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_homework}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'section_id', 'pic_url', 'status', 'submit_time', 'user_id'], 'required'],
            [['course_id', 'section_id', 'status', 'user_id'], 'integer'],
            [['pic_url'], 'string'],
            [['submit_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_id' => Yii::t('app', '对应课程'),
            'section_id' => Yii::t('app', '节次'),
            'pic_url' => Yii::t('app', '提交作业图片'),
            'status' => Yii::t('app', '状态'),
            'submit_time' => Yii::t('app', '提交时间'),
            'user_id' => Yii::t('app', '用户'),
        ];
    }

    /**
     * @inheritdoc
     * @return UserHomeworkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserHomeworkQuery(get_called_class());
    }
}
