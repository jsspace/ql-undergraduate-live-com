<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_news}}".
 *
 * @property string $id
 * @property string $title
 * @property string $list_pic
 * @property string $des
 * @property string $courseid
 * @property integer $onuse
 * @property integer $position
 * @property integer $view
 * @property integer $create_time
 */
class CourseNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'des'], 'required'],
            [['des'], 'string'],
            [['onuse', 'position', 'view', 'create_time'], 'integer'],
            [['title', 'list_pic', 'courseid'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '标题'),
            'list_pic' => Yii::t('app', '列表图片'),
            'des' => Yii::t('app', '内容'),
            'courseid' => Yii::t('app', '相关课程'),
            'onuse' => Yii::t('app', '是否可用'),
            'position' => Yii::t('app', '排序'),
            'view' => Yii::t('app', '浏览次数'),
            'create_time' => Yii::t('app', '日期'),
        ];
    }

    /**
     * @inheritdoc
     * @return CourseNewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseNewsQuery(get_called_class());
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
