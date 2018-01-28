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
 * @property integer $invite
 * @property string $wechat
 * @property string $wechat_img
 * @property double $percentage
 * @property string $cityid
 * @property string $provinceid
 */
class User extends \yii\db\ActiveRecord
{
    public $password;
    
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
            [['username', 'email', 'phone'], 'required'],
            [['status', 'created_at', 'updated_at', 'gender', 'invite'], 'integer'],
            [['intro', 'password'], 'string'],
            [['percentage'], 'number'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'phone', 'picture'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2000],
            [['unit', 'office', 'goodat', 'wechat_img'], 'string', 'max' => 300],
            [['wechat'], 'string', 'max' => 200],
            [['cityid', 'provinceid'], 'string', 'max' => 20]
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
            'password' => Yii::t('app', '密码'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', '邮箱'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'phone' => Yii::t('app', '电话'),
            'gender' => Yii::t('app', '性别'),
            'description' => Yii::t('app', '简短描述'),
            'unit' => Yii::t('app', '单位'),
            'office' => Yii::t('app', '职务'),
            'goodat' => Yii::t('app', '擅长'),
            'picture' => Yii::t('app', '照片'),
            'intro' => Yii::t('app', '介绍'),
            'invite' => Yii::t('app', '邀请人'),
            'wechat' => Yii::t('app', '微信号'),
            'wechat_img' => Yii::t('app', '微信二维码'),
            'percentage' => Yii::t('app', '提成比例'),
            'provinceid' => Yii::t('app', '省份'),
            'cityid' => Yii::t('app', '地级市'),
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
    private static $all_users=array();
    
    public static function users($roleName)
    {
        if(!isset(self::$_users[$roleName]))
            self::loadUsers($roleName);
            return self::$_users[$roleName];
    }
    
    public static function user($roleName,$id)
    {
        if(!isset(self::$_users[$roleName]))
            self::loadUsers($roleName);
            return isset(self::$_users[$roleName][$$id]) ? self::$_users[$roleName][$id] : false;
    }
    
    private static function loadUsers($roleName)
    {
        self::$_users[$roleName]=array();
        $userIds = Yii::$app->authManager->getUserIdsByRole($roleName);
        $models = self::find()
        ->where(['in', 'id', $userIds])
        ->orderBy('id desc')
        ->all();
        foreach($models as $model)
            self::$_users[$roleName][$model->id]=$model->username;
    }
    
    private static $_item=array();
    
    public static function item($id)
    {
        if(!isset(self::$_item[$id]))
            self::loadItem();
            return isset(self::$_item[$id]) ? self::$_item[$id] : false;
    }
    
    private static function loadItem()
    {
        $umodels = User::find()
        ->all();
        foreach ($umodels as $umodel) {
            self::$_item[$umodel->id]=$umodel->username;
        }
    }

    public static function getAllUsers()
    {
        $umodels = User::find()
        ->all();
        foreach ($umodels as $key => $umodel) {
            self::$all_users[$umodel->id]=$umodel->username;
        }
        return self::$all_users;
    }

    public static function getUserModel($id) {
        $userModel = self::find()
        ->where(['id' => $id])
        ->one();
        return $userModel;
    }
    public static function getUserByName($username, $pass) {
        $userModel = self::find()
        ->where(['username' => $username])
        ->one();
        $result = 0;
        if ($userModel) {
            $result = Yii::$app->security->validatePassword($pass, $userModel->password_hash);
        }
        if ($result == 1) {
            return $userModel;
        } else {
            return '';
        }
    }
    public static function getUserByrole($roleName) {
        $userIds = Yii::$app->authManager->getUserIdsByRole($roleName);
        $models = self::find()
        ->where(['in', 'id', $userIds])
        ->orderBy('id desc')
        ->all();
        return $models;
    }
    
    public static function isAdmin($id) {
        if ($id) {
           $userid = $id;
        } else {
            $userid = Yii::$app->user->id;
        }
        $roles_array = Yii::$app->authManager->getRolesByUser($userid);
        if(array_key_exists('admin',$roles_array)) {
            return 1;
        }
        return 0;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                if (empty($this->picture)) {
                    $this->picture = 'img/default_head_img.jpg';
                }
                if (empty($this->percentage)) {
                    $this->percentage = 0;
                }
                $this->created_at = time();
            } else {
                if (!empty($this->password)) {
                    $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                }
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
    
//     public function afterSave($insert, $changedAttributes)
//     {
//         parent::afterSave($insert, $changedAttributes);
    
//         if ($insert) {
//             $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
// //             $this->save(false, ['password_hash']);
//         }
//     }
}
