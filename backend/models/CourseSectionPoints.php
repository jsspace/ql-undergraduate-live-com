<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_section_points}}".
 *
 * @property string $id
 * @property string $name 名称
 * @property int $position 排序
 * @property int $type 网课/直播课/直播答疑
 * @property string $start_time 开始时间
 * @property string $explain_video_url 习题讲解url
 * @property string $video_url 视频地址
 * @property string $roomid roomid
 * @property string $duration 时长
 * @property string $playback_url 回放地址
 * @property int $paid_free 收费/免费
 * @property string $section_id 所属节
 *
 * @property CourseSection $section
 */
class CourseSectionPoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_section_points}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'video_url', 'duration', 'paid_free', 'section_id'], 'required'],
            [['position', 'type', 'section_id'], 'integer'],
            [['start_time'], 'safe'],
            [['name', 'explain_video_url', 'video_url', 'playback_url'], 'string', 'max' => 255],
            [['roomid', 'duration'], 'string', 'max' => 50],
            [['paid_free'], 'string', 'max' => 4],
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
            'name' => Yii::t('app', '名称'),
            'position' => Yii::t('app', '排序'),
            'type' => Yii::t('app', '网课/直播课/直播答疑'),
            'start_time' => Yii::t('app', '开始时间'),
            'explain_video_url' => Yii::t('app', '习题讲解url'),
            'video_url' => Yii::t('app', '视频地址'),
            'roomid' => Yii::t('app', 'roomid'),
            'duration' => Yii::t('app', '时长(分钟)'),
            'playback_url' => Yii::t('app', '回放地址'),
            'paid_free' => Yii::t('app', '收费/免费'),
            'section_id' => Yii::t('app', '所属节'),
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
     * 建立和学习日志的关系
     * @return \yii\db\ActiveQuery
     */
    public function getStudyLog()
    {
        return $this->hasMany(UserStudyLog::className(), ['pointid' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CourseSectionPointsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseSectionPointsQuery(get_called_class());
    }

    private static $_items=array();
    public static function item($id)
    {
        if(!isset(self::$_items[$id]))
            self::loadItems();
            return isset(self::$_items[$id]) ? self::$_items[$id] : false;
    }
    public static function loadItems() {
        $models = self::find()
        ->all();
        foreach ($models as $model) {
            self::$_items[$model->id] = $model->name;
        }
    }
}
