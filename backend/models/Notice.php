<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%notice}}".
 *
 * @property integer $id
 * @property string $title
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '公告标题'),
        ];
    }

    /**
     * @inheritdoc
     * @return NoticeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NoticeQuery(get_called_class());
    }
}
