<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%course_category}}".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 * @property string $des
 *
 * @property CourseCategory $parent
 * @property CourseCategory[] $courseCategories
 */
class CourseCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['parent_id'], 'integer'],
            [['des'], 'string'],
            [['name'], 'string', 'max' => 255],
            //[['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => CourseCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '分类名称'),
            'parent_id' => Yii::t('app', '父级分类'),
            'des' => Yii::t('app', '分类描述'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CourseCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseCategories()
    {
        return $this->hasMany(CourseCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CourseCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseCategoryQuery(get_called_class());
    }

    private static $_items = array();
    public static function items()
    {
        if (count(self::$_items)==0) {
            self::loadItems();
        }
        return self::$_items;
    }

    public static function item($id)
    {
        if (!isset(self::$_items[$id])) {
            self::loadItems();
        }
       return isset(self::$_items[$id]) ? self::$_items[$id] : false;
    }

    private static function loadItems()
    {
        $models=self::find()
        //->where(['parent_id'=>0])
        ->all();
        foreach ($models as $model) {
            self::$_items[$model->id] = $model->name;
        }
    }

    public static function hotitems()
    {
        $models=self::find()
        ->where(['parent_id'=>0])
        ->all();
        $data = array();
        foreach ($models as $model) {
            $data[$model->id] = $model->name;
        }
        return $data;
    }
    public static function getNames($ids) {
        $ids_arr = explode(',', $ids);
        $cats = self::find()
        ->where(['id' => $ids_arr])
        ->all();
        $cat_names = '';
        foreach ($cats as $key => $cat) {
            if (!empty($cat->name)) {
                $cat_names.=$cat->name.',';
            }
        }
        $cat_names = substr($cat_names,0,strlen($cat_names)-1);
        return $cat_names;
    }
}
