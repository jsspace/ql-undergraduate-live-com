<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%notice}}".
 *
 * @property string $id
 * @property string $theme 主题
 * @property string $url 链接
 * @property int $position 显示顺序
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
            [['theme'], 'required'],
            [['position'], 'integer'],
            [['theme'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'theme' => Yii::t('app', '主题'),
            'url' => Yii::t('app', '链接（无链接填写#）'),
            'position' => Yii::t('app', '显示顺序'),
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
