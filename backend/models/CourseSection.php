<?php

namespace backend\models;
use backend\models\CourseChapter;
use Yii;

/**
 * This is the model class for table "{{%course_section}}".
 *
 * @property string $id
 * @property string $course_id
 * @property string $name
 * @property integer $position
 * @property integer $type
 * @property string $start_time
 * @property string $video_url
 * @property string $roomid
 * @property string $duration
 * @property string $playback_url 
 * @property integer $paid_free 
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
            [['course_id', 'name', 'video_url', 'duration', 'paid_free', 'roomid'], 'required'],
            [['course_id', 'position', 'type', 'paid_free'], 'integer'],
            [['start_time'], 'safe'],
            [['name', 'video_url', 'playback_url'], 'string', 'max' => 255],
            [['duration','roomid'], 'string', 'max' => 50],
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
            'type' => Yii::t('app', '网课/直播课/直播答疑'),
            'start_time' => Yii::t('app', '开始时间'),
            'video_url' => Yii::t('app', '视频地址'),
            'roomid' => Yii::t('app', '房间号'),
            'duration' => Yii::t('app', '时长（分钟）'),
            'playback_url' => Yii::t('app', '回放地址'), 
            'paid_free' => Yii::t('app', '付费/免费'), 
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
     * @inheritdoc
     * @return CourseSectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseSectionQuery(get_called_class());
    }

    /*public static function getCourse($roomid)
    {
        $section = self::find()
        ->where(['roomid' => $roomid])
        ->one();
        if (!empty($section)) {
            $chapter = CourseChapter::find()
            ->where(['id' => $section->course_id])
            ->one();
            return $chapter->course_id;
        }
    }*/
    private static $_items = array();
    public static function item($id)
    {
        if(!isset(self::$_items[$id]))
            self::loadItems();
            return isset(self::$_items[$id]) ? self::$_items[$id] : false;
    }
    public static function items($courseid)
    {
        /* 所有章 */
        /*$chapters = CourseChapter::find()
        ->select('id')
        ->where(['course_id' => $courseid])
        ->asArray()
        ->all();*/
        /* 所有节 */
        $sections = self::find()
        ->where(['course_id' => $courseid])
        ->all();
        $result = array();
        if (empty($sections)) {
            foreach ($sections as $section) {
               $result[$section->id] = $section->name;
            }
        }
        return $result;
    }
    public static function loadItems() {
        $models = self::find()
        ->all();
        foreach ($models as $model) {
            self::$_items[$model->id] = $model->name;
        }
    }
}
