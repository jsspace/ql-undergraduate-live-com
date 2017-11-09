<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Password reset form
 */
class ChangePasswordForm extends Model
{
    public $phone;
    public $change_password_code;
    public $password;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone','match','pattern'=>'/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/','message'=>'{attribute}号码格式错误，必须为1开头的11位纯数字'],
            ['phone', 'string', 'min'=>11,'max' => 11,'on' => ['default','login_sms_code']],
            [['phone'], 'isPhoneExist', 'skipOnEmpty' => false, 'skipOnError' => false],
            
            ['change_password_code', 'required','on' => ['default','login_sms_code']],
            ['change_password_code', 'integer','on' => ['default','login_sms_code']],
            [['change_password_code'], 'getLoginCode', 'skipOnEmpty' => false, 'skipOnError' => false],
            
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    
    public function isPhoneExist($attribute, $params)
    {
        $user = User::findByPhone($this->phone);
        if (!$user) {
            $this->addError('phone', '不存在这个手机号用户！');
        }
    }
    
    public function getLoginCode($attribute, $params)
    {
        //检查session是否打开
        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
        }
        $session = Yii::$app->session;
        if (isset($session['change_password_code'])) {
            //取得验证码和短信发送时间session
            $change_password_code = $session['change_password_code']['code'];
            $expire_time = $session['change_password_code']['expire_time'];
            if (time()-$expire_time < 0) {
                if ($this->smscode != $session['change_password_code']['code']) {
                    $this->addError('change_password_code', '验证码的值输入错误！');
                }
            } else {
                $session->remove('change_password_code');
                $this->addError('change_password_code', '验证码的值失效！');
            }
        } else{
            $this->addError('change_password_code', '请输入验证码的值！');
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
