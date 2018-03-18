<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%provinces}}".
 *
 * @property integer $id
 * @property string $provinceid
 * @property string $province
 */
class Provinces extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%provinces}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provinceid', 'province'], 'required'],
            [['provinceid'], 'string', 'max' => 20],
            [['province'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'provinceid' => Yii::t('app', 'Provinceid'),
            'province' => Yii::t('app', 'Province'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProvincesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProvincesQuery(get_called_class());
    }
    private static $_items=array();
    
    public static function items()
    {
        if(!count(self::$_items))
            self::loadItems();
            return self::$_items;
    }
    
    public static function item($provinceid)
    {
        if(!isset(self::$_items[$provinceid]))
            self::loadItems();
            return isset(self::$_items[$provinceid]) ? self::$_items[$provinceid] : false;
    }
    
    private static function loadItems()
    {
        $models=self::find()
        ->all();
        foreach($models as $model) {
            self::$_items[$model->provinceid]=$model->province;
        }
    }
}
