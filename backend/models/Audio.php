<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%audio}}".
 *
 * @property string $id
 * @property string $des
 * @property string $pic
 * @property string $category_id
 * @property integer $click_time
 * @property integer $create_time
 */
class Audio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%audio}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['des', 'pic', 'category_id'], 'required'],
            [['category_id', 'click_time', 'create_time'], 'integer'],
            [['des', 'pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'des' => Yii::t('app', '描述'),
            'pic' => Yii::t('app', '图片'),
            'category_id' => Yii::t('app', '分类'),
            'click_time' => Yii::t('app', '点击次数'),
            'create_time' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * @inheritdoc
     * @return AudioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AudioQuery(get_called_class());
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
    private static $_items = array();

    public static function items()
    {
        if(count(self::$_items) === 0) {
            self::loadItems();
        }
        return self::$_items;
    }
    
    public static function item($id)
    {
        if(!isset(self::$_items[$id])) {
            self::loadItems();
        }
        return isset(self::$_items[$id]) ? self::$_items[$id] : false;
    }
    
    private static function loadItems()
    {
        $models=self::find()
        ->all();
        foreach($models as $model) {
            self::$_items[$model->id]=$model->des;
        }
    }
}
