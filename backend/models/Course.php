<?php

namespace backend\models;
use backend\models\OrderInfo;
use backend\models\MemberOrder;
use backend\models\Member;
use Yii;

/**
 * This is the model class for table "{{%course}}".
 *
 * @property string $id
 * @property string $course_name 课程名字
 * @property string $list_pic 列表图片
 * @property string $home_pic 封面图片
 * @property string $teacher_id 授课教师
 * @property string $price 价格
 * @property string $discount 优惠价格
 * @property CourseCategory $categoryName
 * @property string $des 课程详情
 * @property int $view 浏览次数
 * @property int $collection 收藏次数
 * @property int $share 分享次数
 * @property int $online 在学人数
 * @property int $onuse 是否可用
 * @property int $create_time 课程创建时间
 * @property string $head_teacher 辅导老师
 * @property string $examination_time 模拟考次数
 * @property int $type 热门班级/公开课
 * @property int $open_course_url 公开课链接
 * @property string $intro 课程简介
 * @property string $duration 课程时长
 * @property string $position
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_name', 'teacher_id', 'price', 'discount', 'des', 'type', 'intro'], 'required'],
            [['list_pic'], 'required', 'on'=> 'create'],
            [['category_name', 'view', 'collection', 'share', 'online', 'onuse', 'create_time', 'examination_time', 'position'], 'integer'],
            [['price', 'discount'], 'number'],
            [['des'], 'string'],
            [['teacher_id'], 'string', 'max' => 255],
            [['course_name', 'list_pic', 'home_pic', 'category_name', 'head_teacher', 'open_course_url', 'intro'], 'string', 'max' => 255],
            [['category_name'], 'exist', 'skipOnError' => true, 'targetClass' => CourseCategory::className(), 'targetAttribute' => ['category_name' => 'id']]
            // [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['teacher_id' => 'id']],
            // [['head_teacher'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['head_teacher' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_name' => Yii::t('app', '课程名字'),
            'list_pic' => Yii::t('app', '列表图片'),
            'home_pic' => Yii::t('app', '封面图片'),
            'teacher_id' => Yii::t('app', '授课教师'),
            'price' => Yii::t('app', '价格'),
            'discount' => Yii::t('app', '优惠价格'),
            'category_name' => Yii::t('app', '课程分类'),
            'des' => Yii::t('app', '课程详情'),
            'view' => Yii::t('app', '浏览次数'),
            'collection' => Yii::t('app', '收藏次数'),
            'share' => Yii::t('app', '分享次数'),
            'online' => Yii::t('app', '在学人数'),
            'onuse' => Yii::t('app', '是否可用'),
            'create_time' => Yii::t('app', '课程创建时间'),
            'head_teacher' => Yii::t('app', '班主任'),
            'examination_time' => Yii::t('app', '模拟考次数'),
            'type' => Yii::t('app', '热门班级/公开课'),
            'open_course_url' => Yii::t('app', '公开课链接'),
            'intro' => Yii::t('app', '课程简介'),
            'duration' => Yii::t('app', '课程时长'),
            'position' => Yii::t('app', '课程排序')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(User::className(), ['id' => 'teacher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCategoryName()
   {
       return $this->hasOne(CourseCategory::className(), ['id' => 'category_name']);
   }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getHeadTeacher()
    {
        return $this->hasOne(User::className(), ['id' => 'head_teacher']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseChapters()
    {
        return $this->hasMany(CourseChapter::className(), ['course_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseQuery(get_called_class());
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
    public static function item($id)
    {
        if(!isset(self::$_items[$id]))
            self::loadItems();
            return isset(self::$_items[$id]) ? self::$_items[$id] : false;
    }
    public static function items($ids)
    {
        $course = '';
        $idarrs = explode(',', $ids);
        foreach ($idarrs as $idarr) {
            if (!isset(self::$_items[$idarr])) {
                self::loadItems();
            }
            $course.=self::$_items[$idarr].',';
        }
        $new_course = substr($course,0,strlen($course)-1);
        return $new_course;
    }
    public static function allItems() {
        self::loadItems();
        return self::$_items;
    }
    public static function loadItems() {
        $models = self::find()
        ->all();
        foreach ($models as $model) {
            self::$_items[$model->id] = $model->course_name;
        }
    }

    public static function ismember($course_id, $user_id)
    {
        $current_time = time();
        $member_orders = MemberGoods::find()
        ->where(['user_id' => $user_id])
        ->andWhere(['pay_status' => 2])
        ->andWhere(['>', 'end_time', $current_time])
        ->all();
        $category_ids = '';
        foreach ($member_orders as $member) {
            $category_ids .= $member->course_category_id.',';
        }
        $category_ids_arr = explode(',', $category_ids);//当前用户所有会员订单对应的课程分类ids数组
        $category_ids_arr = array_filter($category_ids_arr);
        $course = Course::find()
        ->where(['id' => $course_id])
        ->one();
        $current_cids = $course->category_name;
        $current_cid_arr = explode(',', $current_cids);
        $catModels = CourseCategory::find()
        ->where(['id' => $current_cid_arr])
        ->all();
        $current_pids = '';
        foreach ($catModels as $key => $catModel) {
            $current_pids.=$catModel->parent_id.',';
        }
        $current_pid_arr = array_filter(explode(',', $current_pids));
        $is_member = 0;
        foreach ($current_pid_arr as $key => $current_pid) {
            if (in_array($current_pid, $category_ids_arr)) {
                $is_member = 1;
                break;
            }
        }
        return $is_member;
    }
    public static function ispay($course_id, $user_id)
    {
        $orders = OrderInfo::find()
        ->where(['user_id' => $user_id])
        ->andWhere(['pay_status' => 2])
        ->all();
        $course_ids = '';
        $ispay = 0;
        if (!empty($orders)) {
            foreach ($orders as $key => $order) {
                $course_ids .= $order->course_ids.',';
            }
            $course_ids = explode(',', $course_ids);
            if (in_array($course_id, $course_ids)) {
                $ispay = 1;
            } else {
                $ispay = 0;
            }
        } else {
            $ispay = 0;
        }
        return $ispay;
    }
    public static function getCourse($ids)
    {
        $idarr = explode(',', $ids);
        $courses = self::find()
        ->where(['id' => $idarr])
        ->all();
        foreach ($courses as $key => $course) {
            
        }
        return $courses;
    }
    public static function teacher($id)
    {
        $course = self::find()
        ->where(['id' => $id])
        ->one();
        return $course->teacher_id;
    }
}
