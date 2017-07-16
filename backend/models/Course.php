<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course}}".
 *
 * @property string $id
 * @property string $course_name
 * @property string $list_pic
 * @property string $home_pic
 * @property integer $teacher_id
 * @property string $price
 * @property string $discount
 * @property string $category_name
 * @property string $des
 * @property integer $view
 * @property integer $collection
 * @property integer $share
 * @property integer $online
 * @property integer $onuse
 * @property integer $create_time
 * @property integer $head_teacher
 *
 * @property User $teacher
 * @property User $headTeacher
 * @property CourseChapter[] $courseChapters
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_name', 'list_pic', 'home_pic', 'teacher_id', 'price', 'discount', 'category_name', 'des', 'head_teacher'], 'required'],
            [['teacher_id', 'view', 'collection', 'share', 'online', 'onuse', 'create_time', 'head_teacher'], 'integer'],
            [['price', 'discount'], 'number'],
            [['des'], 'string'],
            [['course_name', 'list_pic', 'home_pic', 'category_name'], 'string', 'max' => 255],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['teacher_id' => 'id']],
            [['head_teacher'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['head_teacher' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_name' => Yii::t('app', '课程名字'),
            'list_pic' => Yii::t('app', '列表图片'),
            'home_pic' => Yii::t('app', '封面图片'),
            'teacher_id' => Yii::t('app', '授课教师'),
            'price' => Yii::t('app', '价格'),
            'discount' => Yii::t('app', '优惠价格'),
            'category_name' => Yii::t('app', '课程分类'),
            'des' => Yii::t('app', '课程详情'),
            'view' => Yii::t('app', '浏览次数'),
            'collection' => Yii::t('app', '收藏次数'),
            'share' => Yii::t('app', '分享次数'),
            'online' => Yii::t('app', '在学人数'),
            'onuse' => Yii::t('app', '是否可用'),
            'create_time' => Yii::t('app', '课程创建时间'),
            'head_teacher' => Yii::t('app', '班主任'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(User::className(), ['id' => 'teacher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeadTeacher()
    {
        return $this->hasOne(User::className(), ['id' => 'head_teacher']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseChapters()
    {
        return $this->hasMany(CourseChapter::className(), ['course_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseQuery(get_called_class());
    }
}
