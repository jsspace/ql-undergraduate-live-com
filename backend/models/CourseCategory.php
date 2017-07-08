<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_category}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $parent_id
 * @property string $des
 */
class CourseCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['des'], 'string', 'max' => 600],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '分类名称'),
            'parent_id' => Yii::t('app', '父级分类'),
            'des' => Yii::t('app', '分类描述'),
        ];
    }

    /**
     * @inheritdoc
     * @return CourseCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseCategoryQuery(get_called_class());
    }
}
