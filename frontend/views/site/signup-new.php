<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/loginRegister.css');

$this->title = 'Signup';
?>
<div class="site-login-register site-signup">
    <div class="login-kuang">
        <div class="login-bg">
            <form id="form-signup" action="/site/signup" method="post" role="form">
                <input type="hidden" name="_csrf-frontend" value="iAD77CACntBQFi2L50awIuGRfmJ2RA8LuXwTVnNDQ2z-wEDIyO1sD9Q9AdXIC-YQOmV3E0RkCNjXdK4XImUd9w==">

                <p class="signup-line">
                    <input type="text" class="form-control signup-input" placeholder="用户名"/>
                </p>

                <p class="signup-line">
                    <input type="text" class="form-control signup-input" placeholder="手机号"/>
                </p>

                <p class="signup-line verify-code">
                    <input type="text" class="form-control verify-input" placeholder="验证码" />
                    <a href="javascript:void(0)" class="btn verify-btn">获取验证码</a>
                </p>

                <p class="signup-line">
                    <input type="text" class="form-control signup-input" placeholder="密码"/>
                </p>

                <p class="signup-line">
                    <button type="submit" class="btn submit-btn">注册</button>
                </p>

            </form>
        </div>
    </div>
</div>
