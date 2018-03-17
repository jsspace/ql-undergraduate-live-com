<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%audio_category}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $parent_id
 * @property string $des
 * @property integer $position
 */
class AudioCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%audio_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id', 'position'], 'integer'],
            [['des'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '分类名'),
            'parent_id' => Yii::t('app', '父级分类'),
            'des' => Yii::t('app', '分类描述'),
            'position' => Yii::t('app', '排序'),
        ];
    }

    /**
     * @inheritdoc
     * @return AudioCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AudioCategoryQuery(get_called_class());
    }
}
