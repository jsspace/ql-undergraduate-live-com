<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%friendly_links}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $src
 * @property integer $position
 */
class FriendlyLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%friendly_links}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'src'], 'required'],
            [['position'], 'integer'],
            [['title', 'src'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '名称'),
            'src' => Yii::t('app', '链接'),
            'position' => Yii::t('app', '排序'),
        ];
    }

    /**
     * @inheritdoc
     * @return FriendlyLinksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FriendlyLinksQuery(get_called_class());
    }
}
