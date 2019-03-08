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
 * @property string $homework 节次对应的作业
 * @property string $explain_video_url 作业视频讲解链接
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
            [['homework'], 'string'],
            [['name', 'explain_video_url'], 'string', 'max' => 255],
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
            'homework' => Yii::t('app', '节次对应的作业'),
            'explain_video_url' => Yii::t('app', '作业视频讲解链接'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getUserHomework()
    {
        return $this->hasMany(UserHomework::className(), ['section_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CourseSectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseSectionQuery(get_called_class());
    }

    private static $_items = array();
    public static function item($id)
    {
        if(!isset(self::$_items[$id]))
            self::loadItems();
        return isset(self::$_items[$id]) ? self::$_items[$id] : false;
    }
    public static function items($ids)
    {
        $course_section = '';
        $idarrs = explode(',', $ids);
        foreach ($idarrs as $idarr) {
            if (!isset(self::$_items[$idarr])) {
                self::loadItems();
            }
            $course_section.=self::$_items[$idarr].',';
        }
        $new_course_section = substr($course_section,0,strlen($course_section)-1);
        return $new_course_section;
    }
    public static function allItems() {
        self::loadItems();
        return self::$_items;
    }
    public static function loadItems() {
        $models = self::find()
            ->all();
        foreach ($models as $model) {
            self::$_items[$model->id] = $model->name;
        }
    }

    
}
