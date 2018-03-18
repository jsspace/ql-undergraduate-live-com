<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%cooperation}}".
 *
 * @property integer $id
 * @property string $pic
 * @property string $src
 * @property string $title
 */
class Cooperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cooperation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pic', 'src'], 'required'],
            [['pic', 'src', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pic' => Yii::t('app', '合作者机构的图片'),
            'src' => Yii::t('app', '合作者机构的链接地址'),
            'title' => Yii::t('app', '对合作单位的描述（名称）'),
        ];
    }

    /**
     * @inheritdoc
     * @return CooperationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CooperationQuery(get_called_class());
    }
}
