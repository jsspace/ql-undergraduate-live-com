<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\AuthAssignment;

/**
 * Signup form
 */
class ApiSignupForm extends Model
{
    public $phone;
    public $smscode;
    public $password;
    public $invite;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['phone', 'trim'],
            ['phone', 'required', 'message' => '电话号码不能为空'],
            ['phone','match','pattern'=>'/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/','message'=>'电话号码格式错误，必须为1开头的11位纯数字'],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => '电话号码被占用'],
            ['phone', 'string', 'min'=>11,'max' => 11,'on' => ['default','login_sms_code']],
            
            ['smscode', 'string', 'min' => 6,'max' => 6, 'tooLong'=>'验证码为6位数字！', 'tooShort'=>'验证码为6位数字！'],
            ['smscode', 'required','on' => ['default','login_sms_code'], 'message' => '验证码不能为空'],
            ['smscode', 'integer','on' => ['default','login_sms_code']],
            ['smscode', 'get_login_code', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['phone', 'get_phone', 'skipOnEmpty' => false, 'skipOnError' => false],
            
            ['password', 'required', 'message' => '密码不能为空'],
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
            'smscode' => Yii::t('app', '验证码'),
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
    
    public function get_login_code($attribute, $params)
    {
        //检查session是否打开
        if(!Yii::$app->session->isActive) {
            Yii::$app->session->open();
        }
        $session = Yii::$app->session;
        if (isset($session['login_sms_code'])) {
            //取得验证码和短信发送时间session
            $signup_sms_code = $session['login_sms_code']['code'];
            $signup_sms_time = $session['login_sms_code']['expire_time'];
            if (time()-$signup_sms_time < 0) { //未过期
                if ($this->smscode != $session['login_sms_code']['code']) {
                    $this->addError('smscode', '验证码输入错误！');
                }
            } else {
                $session->remove('login_sms_code');
                $this->addError('smscode', '验证码过期！');
            }
        } else {
            print_r($session);
            die();
            $this->addError('smscode', '请输入验证码的值！');
        }
    }
    
    public function get_phone($attribute, $params)
    {
        //检查session是否打开
        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
        }
        $session = Yii::$app->session;
        if (isset($session['login_sms_code'])) {
            //取得验证码和短信发送时间session
            $signup_sms_phone = $session['login_sms_code']['phone'];
            $signup_sms_time = $session['login_sms_code']['expire_time'];
            if (time()-$signup_sms_time < 0) {
                if ($this->phone != $session['login_sms_code']['phone']) {
                    $this->addError('smscode', '验证码不匹配！');
                }
            } else {
                $session->remove('login_sms_code');
                $this->addError('smscode', '验证码失效！');
            }
        } else{
            $this->addError('smscode', '请输入验证码的值！');
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
        $user->username = '尊敬的用户';
        $user->email = '';
        $user->phone = $this->phone;
        $user->invite = $this->invite;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();
        
        $role = new AuthAssignment();
        $role->item_name = 'student';
        $role->user_id = $user->id;
        $role->save(false);
        return $user->save() ? $user : null;
    }
}
