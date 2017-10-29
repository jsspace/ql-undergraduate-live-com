<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_coment}}".
 *
 * @property string $id
 * @property integer $course_id
 * @property integer $user_id
 * @property string $content
 * @property integer $check
 * @property integer $create_time
 * @property integer $star
 */
class CourseComent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_coment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'user_id', 'content'], 'required'],
            [['course_id', 'user_id', 'check', 'create_time', 'star'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_id' => Yii::t('app', '评价课程'),
            'user_id' => Yii::t('app', '评价学员'),
            'content' => Yii::t('app', '评价内容'),
            'check' => Yii::t('app', '评价状态'),
            'create_time' => Yii::t('app', '时间'),
            'star' => Yii::t('app', '星级'),
        ];
    }

    /**
     * @inheritdoc
     * @return CourseComentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseComentQuery(get_called_class());
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

    private static $_items = array();
    public static function item($status)
    {
        if(!isset(self::$_items[$status]))
            self::loadItems();
            return isset(self::$_items[$status]) ? self::$_items[$status] : false;
    }
    public static function items()
    {
        self::loadItems();
        return self::$_items;
    }
    public static function loadItems() {
        self::$_items[0] = '待审核';
        self::$_items[1] = '审核通过';
        self::$_items[2] = '审核未通过';
    }
}
