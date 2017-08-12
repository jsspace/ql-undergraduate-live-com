<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_chapter}}".
 *
 * @property string $id
 * @property string $course_id
 * @property string $name
 * @property integer $position
 *
 * @property Course $course
 * @property CourseSection[] $courseSections
 */
class CourseChapter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_chapter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'name'], 'required'],
            [['course_id', 'position'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_id' => Yii::t('app', '所属课程'),
            'name' => Yii::t('app', '名称'),
            'position' => Yii::t('app', '排序'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseSections()
    {
        return $this->hasMany(CourseSection::className(), ['chapter_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CourseChapterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseChapterQuery(get_called_class());
    }
}
