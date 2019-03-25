<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class ApiLoginForm extends Model
{
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => Yii::t('app', '电话号码')
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
                $this->addError($attribute, '手机号不存在或者密码错误');
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
            $accessToken = $this->_user->generateAccessToken();
            $this->_user->expire_at = time()+3600*24*7; //设定token过期时间 7天
            $this->_user->save();
            Yii::$app->user->login($this->_user, 3600*24*7);
            return $accessToken;
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
    
}
