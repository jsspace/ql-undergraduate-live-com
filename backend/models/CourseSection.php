<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_section}}".
 *
 * @property string $id
 * @property string $name 节次名称
 * @property string $chapter_id 所属单元
 * @property int $position 排序
 *
 * @property CourseChapter $chapter
 * @property CourseSectionPoints[] $courseSectionPoints
 */
class CourseSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_section}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'chapter_id'], 'required'],
            [['chapter_id', 'position'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['chapter_id'], 'exist', 'skipOnError' => true, 'targetClass' => CourseChapter::className(), 'targetAttribute' => ['chapter_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '节次名称'),
            'chapter_id' => Yii::t('app', '所属单元'),
            'position' => Yii::t('app', '排序'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChapter()
    {
        return $this->hasOne(CourseChapter::className(), ['id' => 'chapter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseSectionPoints()
    {
        return $this->hasMany(CourseSectionPoints::className(), ['section_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CourseSectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseSectionQuery(get_called_class());
    }

    
}
