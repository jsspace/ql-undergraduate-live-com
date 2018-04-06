<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%ad}}".
 *
 * @property string $id
 * @property string $title 标题
 * @property string $url 链接地址
 * @property string $img 图片路径
 * @property int $position 位置
 * @property int $online 上线|下线
 * @property int $ismobile mobile | pc
 */
class Ad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['position'], 'integer'],
            [['title', 'url'], 'string', 'max' => 200],
            [['img'], 'string', 'max' => 300],
            [['online'], 'string', 'max' => 11],
            [['ismobile'], 'string', 'max' => 4],
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
            'url' => Yii::t('app', '链接地址'),
            'img' => Yii::t('app', '图片路径'),
            'position' => Yii::t('app', '位置'),
            'online' => Yii::t('app', '上线|下线'),
            'ismobile' => Yii::t('app', 'mobile | pc'),
        ];
    }

    /**
     * @inheritdoc
     * @return AdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdQuery(get_called_class());
    }
}
