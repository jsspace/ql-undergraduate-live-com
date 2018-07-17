<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%section_practice}}".
 *
 * @property string $id
 * @property string $section_id 章节
 * @property string $course_id 课程
 * @property string $title 练习题标题
 * @property string $problem_des 练习题问题
 * @property string $answer 练习题答案
 * @property int $create_time 创建时间
 *
 * @property CourseSection $section
 */
class SectionPractice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%section_practice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'problem_des'], 'required'],
            [['section_id', 'course_id', 'create_time'], 'integer'],
            [['problem_des', 'answer'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => CourseSection::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'section_id' => Yii::t('app', '章节'),
            'course_id' => Yii::t('app', '课程'),
            'title' => Yii::t('app', '练习题标题'),
            'problem_des' => Yii::t('app', '练习题问题'),
            'answer' => Yii::t('app', '练习题答案'),
            'create_time' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(CourseSection::className(), ['id' => 'section_id']);
    }

    /**
     * @inheritdoc
     * @return SectionPracticeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SectionPracticeQuery(get_called_class());
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
