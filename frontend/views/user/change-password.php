<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

AppAsset::addCss($this,'@web/css/user.css');

$this->title = '个人中心';
?>
<div class="container-course menu-position">
    <div class="container-inner">
        <span>您的位置：</span>
        <span><a href="/">首页</a></span>
        <span>&gt;</span>
        <span><a href="<?= Url::to(['user/info']) ?>">个人中心</a></span>
    </div>
</div>
<div class="user-wrapper">
    <?= $this->render('lmenu') ?>
    <div class="right-content">
        <div class="pass-reset">
           <div class="site-reset-password">
                <p>修改密码:</p>
                <div class="row">
                    <div class="col-lg-5">
                            <input type="password" placeholder="现有密码" id="historyPwd" />
                            <input type="password" placeholder="新密码" id="newPwd"/>
                            <input type="password" placeholder="重新输入新密码" id="repeatPwd"/>
                            <div class="form-group">
                                <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('button[type="submit"]').on('click', function () {
        var historyPwd = $('#historyPwd').val();
        var newPwd = $('#newPwd').val();
        var repeatPwd = $('#repeatPwd').val();
        if (!historyPwd) {
            alert('请输入密码');
            $('#historyPwd').focus();
            return false;
        }
        if (!newPwd) {
            alert('请输入新密码');
            $('#newPwd').focus();
            return false;
        }
        if (!repeatPwd) {
            alert('请重新输入新密码');
            $('#repeatPwd').focus();
            return false;
        }
        if (newPwd !== repeatPwd) {
            alert('两次密码输入不同，请重新输入');
            $('#repeatPwd').focus();
            return false;
        }
        $.ajax({
            url: "<?= Url::to(['user/change-password']) ?>",
            type: 'post',
            dataType:"json",
            async: false,
            data: {
                '_csrf-frontend': $('meta[name=csrf-token]').attr('content'),
                'old_password': historyPwd,
                'new_password': newPwd,
                'renew_password': repeatPwd
            },
            success: function (data) {
                if (data.status !== 0) {
                    alert(data.message);
                } else {
                	alert(data.message);
                    window.location.href = "<?= Url::to(['/user/info']) ?>";
                }
            }
        });
    });
</script>