<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%admin_session}}".
 *
 * @property int $session_id
 * @property int $id
 * @property string $session_token
 */
class AdminSession extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_session}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'session_token'], 'required'],
            [['id'], 'integer'],
            [['session_token'], 'string', 'max' => 56],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'session_id' => Yii::t('app', 'Session ID'),
            'id' => Yii::t('app', 'ID'),
            'session_token' => Yii::t('app', 'Session Token'),
        ];
    }

    /**
     * @inheritdoc
     * @return AdminSessionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminSessionQuery(get_called_class());
    }
}
