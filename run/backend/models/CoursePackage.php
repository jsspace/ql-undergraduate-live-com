<?php

namespace backend\models;
use backend\models\User;
use backend\models\OrderInfo;
use backend\models\OrderGoods;
use backend\models\CourseCategory;
use Yii;

/**
 * This is the model class for table "{{%course_package}}".
 *
 * @property string $id
 * @property string $name
 * @property string $course
 * @property string $list_pic
 * @property string $home_pic
 * @property string $price
 * @property string $discount
 * @property string $category_name
 * @property string $intro
 * @property string $des
 * @property integer $view
 * @property integer $collection
 * @property integer $share
 * @property integer $online
 * @property integer $onuse
 * @property integer $create_time
 * @property string $head_teacher
 */
class CoursePackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_package}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'discount', 'category_name', 'des', 'intro', 'head_teacher'], 'required'],
            [['list_pic', 'home_pic'], 'required', 'on'=> 'create'],
            [['price', 'discount'], 'number'],
            [['des','intro'], 'string'],
            [['view', 'collection', 'share', 'online', 'onuse', 'create_time'], 'integer'],
            [['name', 'course', 'list_pic', 'home_pic', 'category_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '班级名字'),
            'course' => Yii::t('app', '课程'),
            'list_pic' => Yii::t('app', '列表图片'),
            'home_pic' => Yii::t('app', '封面图片'),
            'price' => Yii::t('app', '价格'),
            'discount' => Yii::t('app', '优惠价格'),
            'category_name' => Yii::t('app', '学院'),
            'des' => Yii::t('app', '班级详情'),
            'intro' => Yii::t('app', '班级简介'),
            'view' => Yii::t('app', '浏览次数'),
            'collection' => Yii::t('app', '收藏次数'),
            'share' => Yii::t('app', '分享次数'),
            'online' => Yii::t('app', '在学人数'),
            'onuse' => Yii::t('app', '是否可用'),
            'create_time' => Yii::t('app', '班级创建时间'),
            'head_teacher' => Yii::t('app', '班主任'),
        ];
    }

    /**
     * @inheritdoc
     * @return CoursePackageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CoursePackageQuery(get_called_class());
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
    /* 获取所有班级列表 */
    private static $_items=array();

    public static function items()
    {
        if(!count(self::$_items)) {
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
        $isadmin = User::isAdmin(Yii::$app->user->id);
        /*if($isadmin === 1) {
            self::$_items['alluser'] = '全部学员';
        }*/
        self::$_items['alluser'] = '全部学员';
        self::$_items['allclass'] = '全部班级';
        $models=self::find()
        ->all();
        foreach($models as $model) {
            self::$_items[$model->id] = $model->name;
        }
    }

    public static function namesById($ids)
    {
        $idArr = explode(',', $ids);
        $names = '';
        foreach ($idArr as $key => $id) {
            $names .= self::item($id).',';
        }
        $names = substr($names,0,strlen($names)-1); 
        return $names;
    }
    public static function getInvalidTime($package_id)
    {
        $order_goods_model = OrderGoods::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['goods_id' => $package_id])
        ->one();
        $order_model = OrderInfo::find()
        ->where(['order_sn' => $order_goods_model->order_sn])
        ->one();
        return $order_model->invalid_time;
    }
    public static function getUserClass()
    {
        $orderinfo_models = OrderInfo::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['order_status' => 1])
        ->andWhere(['pay_status' => 2])
        ->all();
        $order_sns = [];
        $current_time = time();
        $package_invalid_time = [];
        foreach ($orderinfo_models as $orderinfo_model) {
            //支付订单后6个月之内有效
            $invalid_time = $orderinfo_model->pay_time + 3600 * 24 * 180;
            if ($invalid_time > $current_time) {
                $order_sns[] = $orderinfo_model->order_sn;
            }
        }
        //去订单详情表查找班级详细信息
        $order_goods_models = OrderGoods::find()
        ->where(['order_sn' => $order_sns])
        ->andWhere(['type' => 'course_package'])
        ->all();
        $course_package_ids = [];
        foreach ($order_goods_models as $order_goods_model) {
            $course_package_ids[] = $order_goods_model->goods_id;
            $package_invalid_time[$order_goods_model->goods_id] = self::getInvalidTime($order_goods_model->goods_id);
        }
        $course_package_models = self::find()
        ->where(['id' => $course_package_ids])
        ->all();
        $course_package_arr = [];
        foreach ($course_package_models as &$course_package_model) {
//             $course_models = Course::find()
//             ->where(['id' => explode(',', $course_package_model->course)])
//             ->all();
//             $course_package_model->course = $course_models;
            $course_category_model = CourseCategory::find()
            ->where(['id' => $course_package_model->category_name])
            ->one();
            $course_package_model->category_name = $course_category_model->name;
            $head_teacher_model = User::findOne(['id' => $course_package_model->head_teacher]);
            $course_package_model->head_teacher = $head_teacher_model;
            $course_package_arr[$course_category_model->name][] = $course_package_model;
        }
        unset($course_package_model);
        $data = [];
        $data['course_package_arr'] = $course_package_arr;
        $data['package_invalid_time'] = $package_invalid_time;
        return $data;
    }
    public static function isClassMember($classid)
    {
        $orderinfo_models = OrderInfo::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['order_status' => 1])
        ->andWhere(['pay_status' => 2])
        ->all();
        $order_sns = [];
        $current_time = time();
        foreach ($orderinfo_models as $orderinfo_model) {
            //支付订单后6个月之内有效
            $invalid_time = $orderinfo_model->pay_time + 3600 * 24 * 180;
            if ($invalid_time > $current_time) {
                $order_sns[] = $orderinfo_model->order_sn;
            }
        }
        //去订单详情表查找班级详细信息
        $order_goods_models = OrderGoods::find()
        ->where(['order_sn' => $order_sns])
        ->andWhere(['type' => 'course_package'])
        ->all();
        $course_package_ids = [];
        foreach ($order_goods_models as $order_goods_model) {
            $course_package_ids[] = $order_goods_model->goods_id;
        }
        $course_package_models = self::find()
        ->where(['id' => $course_package_ids])
        ->all();
        $classids = array();
        foreach ($course_package_models as $key => $userClass) {
            $classids[] = $userClass->id;
        }
        if (in_array($classid, $classids)) {
            return 1;
        } else {
            return 0;
        }
    }
}
