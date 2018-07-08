<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%user_study_log}}".
 *
 * @property string $id
 * @property string $userid
 * @property integer $start_time
 * @property integer $duration
 * @property string $courseid
 * @property string $sectionid
 * @property integer $type
  * @property integer $current_time
 */
class UserStudyLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_study_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'start_time', 'duration', 'courseid', 'sectionid', 'type', 'current_time'], 'integer'],
            [['start_time', 'duration', 'courseid', 'sectionid'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userid' => Yii::t('app', '用户'),
            'start_time' => Yii::t('app', '学习时间'),
            'duration' => Yii::t('app', '学习时长（分钟）'),
            'courseid' => Yii::t('app', '课程名'),
            'sectionid' => Yii::t('app', '章节名'),
            'type' => Yii::t('app', '知识讲解/单元测验/模拟考试'),
            'current_time' => Yii::t('app', '观看位置'),
        ];
    }

    /**
     * @inheritdoc
     * @return UserStudyLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserStudyLogQuery(get_called_class());
    }
}
