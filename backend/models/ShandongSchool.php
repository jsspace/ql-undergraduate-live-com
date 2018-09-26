<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%shandong_school}}".
 *
 * @property string $id
 * @property string $provinceid 省份
 * @property string $cityid 城市
 * @property string $school_name 学校名称
 */
class ShandongSchool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shandong_school}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provinceid', 'cityid', 'school_name'], 'required'],
            [['provinceid', 'cityid'], 'string', 'max' => 20],
            [['school_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'provinceid' => Yii::t('app', '省份'),
            'cityid' => Yii::t('app', '城市'),
            'school_name' => Yii::t('app', '学校名称'),
        ];
    }

    /**
     * @inheritdoc
     * @return ShandongSchoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShandongSchoolQuery(get_called_class());
    }
    
    private static $item = array();
    private static $schools = array();
    
    public static function items()
    {
        if(count(self::$item) === 0) {
            self::loadItem();
        }
        return self::$item;
    }
    
    public static function item($schoolid)
    {
        if(!isset(self::$item[$schoolid])) {
            self::loadItem();
        }
        return isset(self::$item[$schoolid]) ? self::$item[$schoolid] : false;
    }
    
    private static function loadItem()
    {
        $models=self::find()
        ->all();
        foreach($models as $model) {
            self::$item[$model->id] = $model->school_name;
        }
    }

    public static function schools($cityid) {
        $models=self::find()
        ->where(['cityid' => $cityid])
        ->all();
        foreach($models as $model) {
            self::$schools[$model->id] = $model->school_name;
        }
        return self::$schools;
    }
}
