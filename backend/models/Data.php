<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%data}}".
 *
 * @property string $id
 * @property string $name
 * @property string $list_pic
 * @property string $summary
 * @property string $content
 * @property string $course_id
 * @property string $ctime
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'list_pic', 'summary', 'content'], 'required'],
            [['summary', 'content'], 'string'],
            [['course_id'], 'integer'],
            [['name', 'list_pic', 'ctime'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '资料名称'),
            'list_pic' => Yii::t('app', '列表图片'),
            'summary' => Yii::t('app', '概述'),
            'content' => Yii::t('app', '资料详情'),
            'course_id' => Yii::t('app', '相关课程'),
            'ctime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return DataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DataQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->ctime = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
