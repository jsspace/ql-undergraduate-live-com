<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%cities}}".
 *
 * @property integer $id
 * @property string $cityid
 * @property string $city
 * @property string $provinceid
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cities}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityid', 'city', 'provinceid'], 'required'],
            [['cityid', 'provinceid'], 'string', 'max' => 20],
            [['city'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cityid' => Yii::t('app', 'Cityid'),
            'city' => Yii::t('app', 'City'),
            'provinceid' => Yii::t('app', 'Provinceid'),
        ];
    }

    /**
     * @inheritdoc
     * @return CitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }
    private static $_items=array();
    
    private static $item=array();
    
    public static function items($provinceid)
    {
        if(!isset(self::$_items[$provinceid])) {
            self::loadItems($provinceid);
        }
        return self::$_items[$provinceid];
    }
    
    public static function item($cityid)
    {
        if(!isset(self::$item[$cityid])) {
            self::loadItem();
        }
        return isset(self::$item[$cityid]) ? self::$item[$cityid] : false;
    }
    
    private static function loadItems($provinceid)
    {
        self::$_items[$provinceid]=array();
        $models=self::find()
        ->where(['provinceid' => $provinceid])
        ->all();
        foreach($models as $model) {
            self::$_items[$provinceid][$model->cityid]=$model->city;
        }
    }
    
    private static function loadItem()
    {
        $models=self::find()
        ->all();
        foreach($models as $model) {
            self::$item[$model->cityid] = $model->city;
        }
    }
}
