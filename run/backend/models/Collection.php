<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%collection}}".
 *
 * @property string $id
 * @property string $courseid
 * @property string $userid
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%collection}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courseid', 'userid'], 'required'],
            [['courseid', 'userid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'courseid' => Yii::t('app', '收藏课程'),
            'userid' => Yii::t('app', '收藏学员'),
        ];
    }

    /**
     * @inheritdoc
     * @return CollectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CollectionQuery(get_called_class());
    }
}
