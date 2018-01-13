<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_package}}".
 *
 * @property string $id
 * @property string $name
 * @property string $course
 * @property string $list_pic
 * @property string $home_pic
 * @property string $price
 * @property string $discount
 * @property string $category_name
 * @property string $intro
 * @property string $des
 * @property integer $view
 * @property integer $collection
 * @property integer $share
 * @property integer $online
 * @property integer $onuse
 * @property integer $create_time
 * @property string $head_teacher
 */
class CoursePackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_package}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'discount', 'category_name', 'des', 'intro', 'head_teacher'], 'required'],
            [['list_pic', 'home_pic'], 'required', 'on'=> 'create'],
            [['price', 'discount'], 'number'],
            [['des','intro'], 'string'],
            [['view', 'collection', 'share', 'online', 'onuse', 'create_time'], 'integer'],
            [['name', 'course', 'list_pic', 'home_pic', 'category_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '班级名字'),
            'course' => Yii::t('app', '课程'),
            'list_pic' => Yii::t('app', '列表图片'),
            'home_pic' => Yii::t('app', '封面图片'),
            'price' => Yii::t('app', '价格'),
            'discount' => Yii::t('app', '优惠价格'),
            'category_name' => Yii::t('app', '学院'),
            'des' => Yii::t('app', '班级详情'),
            'intro' => Yii::t('app', '班级简介'),
            'view' => Yii::t('app', '浏览次数'),
            'collection' => Yii::t('app', '收藏次数'),
            'share' => Yii::t('app', '分享次数'),
            'online' => Yii::t('app', '在学人数'),
            'onuse' => Yii::t('app', '是否可用'),
            'create_time' => Yii::t('app', '班级创建时间'),
            'head_teacher' => Yii::t('app', '班主任'),
        ];
    }

    /**
     * @inheritdoc
     * @return CoursePackageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CoursePackageQuery(get_called_class());
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
