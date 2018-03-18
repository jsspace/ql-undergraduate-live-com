<?php
namespace common\models;

use Yii;
use yii\base\Model;
use backend\models\AdminSession;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $phone;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['phone', 'password'], 'required'],
            ['phone', 'trim'],
            ['phone','match','pattern'=>'/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/','message'=>'{attribute}号码格式错误，必须为1开头的11位纯数字'],
            ['phone', 'string', 'min'=>11,'max' => 11],
            
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUserbyphone();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect phone or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUserbyphone();
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[phone]]
     *
     * @return User|null
     */
    protected function getUserbyphone()
    {
        if ($this->_user === null) {
            $this->_user = User::findByPhone($this->phone);
        }
    
        return $this->_user;
    }
    
    public static function insertSession($id,$sessionToken)
    {
        $loginAdmin = AdminSession::findOne(['id' => $id]); //查询admin_session表中是否有用户的登录记录
        if(!$loginAdmin){ //如果没有记录则新建此记录
            $sessionModel = new AdminSession();
            $sessionModel->id = $id;
            $sessionModel->session_token = $sessionToken;
            $result = $sessionModel->save();
        }else{          //如果存在记录（则说明用户之前登录过）则更新用户登录token
            $loginAdmin->session_token = $sessionToken;
            $result = $loginAdmin->update();
        }
        return $result;
    }
}
