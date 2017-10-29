<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\AuthAssignment;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $invite;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '此用户名已经被占用了。'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '此邮箱已经被使用了。'],
            
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone','match','pattern'=>'/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/','message'=>'{attribute}号码格式错误，必须为1开头的11位纯数字'],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => '{attribute}已经被占用了'],
            ['phone', 'string', 'min'=>11,'max' => 11,'on' => ['default','login_sms_code']],
            
            ['smsCode', 'required','on' => ['default','login_sms_code']],
            ['smsCode', 'integer','on' => ['default','login_sms_code']],
            ['smsCode', 'string', 'min'=>6,'max' => 6,'on' => ['default','login_sms_code']],
            ['smsCode', 'required','requiredValue'=>$this->getSmsCode(),'on' => ['default','login_sms_code'],'message'=>'手机验证码输入错误'],
            
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['invite', 'integer'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', '用户名'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', '密码'),
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
        ];
    }
    
    public function getSmsCode()
    {
        //检查session是否打开
    
        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
        }
        //取得验证码和短信发送时间session
        $signup_sms_code = intval(Yii::$app->session->get('login_sms_code'));
        $signup_sms_time = Yii::$app->session->get('login_sms_time');
        if(time()-$signup_sms_time < 600){
            return $signup_sms_code;
        }else{
            return 888888;
        }
    }
    

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->invite = $this->invite;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        $role = new AuthAssignment();
        $role->item_name = 'student';
        $role->user_id = $model->id;
        $role->save(false);
        return $user->save() ? $user : null;
    }
    
}
