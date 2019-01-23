<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%information}}".
 *
 * @property int $id ID
 * @property string $title 标题
 * @property string $author 作者
 * @property string $content 内容
 * @property string $cover_pic 封面图片
 * @property string $release_time 发布时间
 */
class Information extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%information}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['content'], 'string'],
            [['release_time'], 'safe'],
            [['title', 'author', 'cover_pic'], 'string', 'max' => 255],
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
            'author' => Yii::t('app', '作者'),
            'content' => Yii::t('app', '内容'),
            'cover_pic' => Yii::t('app', '封面图片'),
            'release_time' => Yii::t('app', '发布时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return InformationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InformationQuery(get_called_class());
    }
}
