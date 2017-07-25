<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_section}}".
 *
 * @property string $id
 * @property string $chapter_id
 * @property string $name
 * @property integer $position
 * @property integer $type
 * @property integer $start_time
 * @property string $video_url
 * @property string $duration
 *
 * @property CourseChapter $chapter
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
            [['chapter_id', 'name', 'start_time', 'video_url', 'duration'], 'required'],
            [['chapter_id', 'position', 'type', 'start_time'], 'integer'],
            [['name', 'video_url'], 'string', 'max' => 255],
            [['duration'], 'string', 'max' => 50],
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
            'chapter_id' => Yii::t('app', '所属章'),
            'name' => Yii::t('app', '名称'),
            'position' => Yii::t('app', '排序'),
            'type' => Yii::t('app', '网课/直播课'),
            'start_time' => Yii::t('app', '开始时间'),
            'video_url' => Yii::t('app', '视频地址'),
            'duration' => Yii::t('app', '时长'),
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
     * @inheritdoc
     * @return CourseSectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseSectionQuery(get_called_class());
    }
}
