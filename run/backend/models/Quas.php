<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%quas}}".
 *
 * @property string $id
 * @property integer $student_id
 * @property integer $teacher_id
 * @property string $question
 * @property string $answer
 * @property integer $question_time
 * @property integer $answer_time
 * @property integer $course_id
 * @property integer $check
 */
class Quas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quas}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'question', 'course_id', 'check'], 'required'],
            [['student_id', 'teacher_id', 'question_time', 'answer_time', 'course_id', 'check'], 'integer'],
            [['question', 'answer'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student_id' => Yii::t('app', '提问题学生'),
            'teacher_id' => Yii::t('app', '回答问题教师'),
            'question' => Yii::t('app', '问题'),
            'answer' => Yii::t('app', '回答'),
            'question_time' => Yii::t('app', '提问题时间'),
            'answer_time' => Yii::t('app', '回答问题时间'),
            'course_id' => Yii::t('app', '相关课程'),
            'check' => Yii::t('app', '审核状态'),
        ];
    }

    /**
     * @inheritdoc
     * @return QuasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuasQuery(get_called_class());
    }
}
