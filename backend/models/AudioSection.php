<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%audio_section}}".
 *
 * @property integer $id
 * @property string $audio_name
 * @property string $audio_author
 * @property string $audio_url
 * @property string $audio_id
 * @property integer $click_time
 * @property integer $collection
 * @property integer $share
 * @property integer $create_time
 */
class AudioSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%audio_section}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'audio_name', 'audio_author', 'audio_url', 'audio_id'], 'required'],
            [['id', 'audio_id', 'click_time', 'collection', 'share', 'create_time'], 'integer'],
            [['audio_name', 'audio_author', 'audio_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'audio_name' => Yii::t('app', '音频名'),
            'audio_author' => Yii::t('app', '音频作者'),
            'audio_url' => Yii::t('app', '音频地址'),
            'audio_id' => Yii::t('app', '音频课'),
            'click_time' => Yii::t('app', '点击次数'),
            'collection' => Yii::t('app', '收藏次数'),
            'share' => Yii::t('app', '分享次数'),
            'create_time' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return AudioSectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AudioSectionQuery(get_called_class());
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
