<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $phone
 * @property integer $gender
 * @property string $description
 * @property string $unit
 * @property string $office
 * @property string $goodat
 * @property string $picture
 * @property string $intro
 * @property integer $code
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'phone'], 'required'],
            [['status', 'created_at', 'updated_at', 'gender', 'code'], 'integer'],
            [['intro'], 'string'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'phone', 'picture'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2000],
            [['unit', 'office', 'goodat'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', '姓名'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', '邮箱'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'phone' => Yii::t('app', '电话'),
            'gender' => Yii::t('app', '性别（男：0，女：1）'),
            'description' => Yii::t('app', '简短描述'),
            'unit' => Yii::t('app', '单位'),
            'office' => Yii::t('app', '职务'),
            'goodat' => Yii::t('app', '擅长'),
            'picture' => Yii::t('app', '照片'),
            'intro' => Yii::t('app', '介绍'),
            'code' => Yii::t('app', '会员码'),
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['teacher_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses0()
    {
        return $this->hasMany(Course::className(), ['head_teacher' => 'id']);
    }
    
    private static $_users=array();
    
    public static function users($roleName)
    {
        if(!isset(self::$_users[$roleName]))
            self::loadUsers($roleName);
            return self::$_users[$roleName];
    }
    
    public static function user($roleName,$id)
    {
        if(!isset(self::$_users[$roleName]))
            self::loadItems($roleName);
            return isset(self::$_users[$roleName][$$id]) ? self::$_users[$roleName][$id] : false;
    }
    
    private static function loadUsers($roleName)
    {
        self::$_users[$roleName]=array();
        $userIds = Yii::$app->authManager->getUserIdsByRole($roleName);
        $models=self::find()
        ->where(['in', 'id', $userIds])
        ->orderBy('id desc')
        ->all();
        foreach($models as $model)
            self::$_users[$roleName][$model->id]=$model->username;
    }
    
    private static $_items=array();
    private static $_item=array();
    
    public static function items($role)
    {
        // if(!isset(self::$_items[$role])) {
        //     self::loadItems($role);
        // }
        // return self::$_items[$role];
    }
    
    public static function item($id)
    {
        if(!isset(self::$_item[$id]))
            self::loadItem();
            return isset(self::$_item[$id]) ? self::$_item[$id] : false;
    }
    
    private static function loadItems($role)
    {
        // self::$_items[$role]=array();
        // $uids=mdm\admin\models\User::getUserIdsByRole($role);
        // foreach($uids as $uid) {
        //     $umodel= User::find()
        //     ->where(['=', 'id', $uid])
        //     ->one();
        //     self::$_items[$role][$umodel->id]=$umodel->username;
        // }
    }
    
    private static function loadItem()
    {
        $umodels= User::find()
        ->all();
        foreach ($umodels as $umodel) {
            self::$_item[$umodel->id]=$umodel->username;
        }
    }
}
