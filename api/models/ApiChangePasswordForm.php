<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset form
 */
class ApiChangePasswordForm extends Model
{
    public $phone;
    public $password;
    public $change_password_code;
    
    /**
     * @var \common\models\User
     */
    private $_user;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['phone', 'trim'],
            ['phone', 'required', 'message' => '电话号码不能为空'],
            ['phone','match','pattern'=>'/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/','message'=>'电话号码格式错误，必须为1开头的11位纯数字'],
            ['phone', 'string', 'min'=>11,'max' => 11,'tooLong'=>'电话号码为11位纯数字！', 'tooShort'=>'电话号码为11位纯数字！'],
            ['phone', 'is_phone_exist', 'skipOnEmpty' => false, 'skipOnError' => false, 'message' => '电话号码不存在'],
            
            ['change_password_code', 'string', 'min'=>6,'max' => 6, 'tooLong'=>'验证码为6位数字！', 'tooShort'=>'验证码为6位数字！'],
            ['change_password_code', 'required','on' => ['default','login_sms_code'], 'message' => '验证码不能为空'],
            ['change_password_code', 'integer','on' => ['default','login_sms_code']],
            ['change_password_code', 'get_login_code', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['phone', 'get_phone', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['password', 'required', 'message' => '密码不能为空'],
            ['password', 'string', 'min' => 6],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone' => Yii::t('app', '手机号'),
            'change_password_code' => Yii::t('app', '验证码'),
            'password' => Yii::t('app', '密码'),
        ];
    }
    
    public function is_phone_exist($attribute, $params)
    {
        $this->_user = User::findByPhone($this->phone);
        if (!$this->_user) {
            $this->addError('phone', '手机号不存在！');
        }
    }
    
    public function get_login_code($attribute, $params)
    {
        //检查session是否打开
        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
        }
        $session = Yii::$app->session;
        if (isset($session['login_sms_code'])) {
            //取得验证码和短信发送时间session
            $signup_sms_code = $session['login_sms_code']['code'];
            $signup_sms_time = $session['login_sms_code']['expire_time'];
            if (time()-$signup_sms_time < 0) {
                if ($this->change_password_code != $session['login_sms_code']['code']) {
                    $this->addError('change_password_code', '验证码输入错误！');
                }
            } else {
                $session->remove('login_sms_code');
                $this->addError('change_password_code', '验证码过期！');
            }
        } else{
            $this->addError('change_password_code', '请输入验证码的值！');
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
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }
}
