<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "{{%smsdata}}".
 *
 * @property string $id
 * @property string $phone
 * @property int $code
 * @property int $expire_time
 * @property int $request_time
 */
class Smsdata extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%smsdata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'code', 'expire_time', 'request_time'], 'required'],
            [['code', 'expire_time', 'request_time'], 'integer'],
            [['phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'code' => 'Code',
            'expire_time' => 'Expire Time',
            'request_time' => 'Request Time',
        ];
    }
}
