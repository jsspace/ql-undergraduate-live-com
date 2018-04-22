<?php
//小程序
$xcx_appid = 'wxa82b0fd068efd444';
$xcx_secret = '5d829699b0455eb9072223bdc03e84ad';


return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'upload_img_dir' => "uploads/img/",
    'alipay' => [
        //应用ID,您的APPID。
        'app_id' => "2017101209266263",
        //商户私钥
        'merchant_private_key' => "MIIEpAIBAAKCAQEAsyVvlzFyf0utZ1URwa1QXIv2z61z9WQus9Rp6M+j2j5gSqft/wt24KbFuYDcfgcOjDAmfYhfkS6AYAtQkv5+FCMgLcgnHhrk2Wf2jYJ9HjbdPmtpsa4NhESiOJ1e9Hix/nnoa/7SmKpDanqt0YjKuCRBW/+BPRiZsJUSZnBRiNjVIC/i9v+H0oIKyAciwEirlrx+8khaufMecPQ4GbFzM3SBDo8Wl0idlfoaCeqZEjvWu5SjhIQ8V4H+3RoKykFWV58WUe2Mht/xn5uEXW6DfPfgWPDYS6NDq10xU318+s3pNbIxvFTF+H95JMAfgpO1xVaJo1z05dH0VR4c4vnR1QIDAQABAoIBAH8Ci5sl84dMoCQiq/QkbFUw5ktXLl9MJ9BXSL9Gd2TD1IEZjiLEfgPIOWbLdYfkeOvrN17I0Pidf2aYnweYZsrgHHBY92Lgrl901dh+KzbArxsSDF1siSi9gEWjTS8GYyuIQsBOagDStflIAPQNh6wGCFCxVW97gXswNVtrRmM+KAPkMItSBXB/0nf3fP58grFgPRieBjGCn+HmrZv3FVVqBFJs/Avd5MncPGKNbvVEfRDPGaJNIeNnwDdb/sN66Q1eICfvnQpZn/YJsO3kccq8OMT19ih7lmkP7ot29TWc1J33nt+eLs1xV9El4GwkjlZw9betLvg10u7t0ZcE0AECgYEA3bafxVrExFBY3SIeSTIGrnLNiXMMDMkwMt3S3gPsV7Z9lCJitO7g4tGt/RaO++c5jdS/occnSbhng44lv0n/B1UPYqku3Lqag7SJlmcoWrf3zRFkM7PyUOfyOuEJII1S+zDEQTMDFozyaNhCuQ7HwLw0d28hDCB1GOuZP3Ex6g0CgYEAztmgwJw3JStjWAHjRM54SQ2Grk7HENolNF1/EAVY71eXOXXGZTkwGcEePQuiZLwA8xkwdBFsytxn3HWWM1mBiMspMShOLKhbDvpbDyeFzvHhux5jaePvXhwQ6k6iMpLCGiADd3Xw/RuutamX7Q2CpKqitZgvWtAXVIKM+OwD/OkCgYEApvggrJTl+F31/lryafcltvy4M1oT6hEdnkEVy6Myuv+w5P1cTpxTeh2kpSP2/FgvLNPamXAM82TPd/B2FvAYAqKZWpjEtPBG6wbsUvtPFbrUAHineJR82VdEQfk1UXF827TnJ57OJY5yBGlRHmK2JjzWWlezkJlk9iZ/m5qYl4UCgYEAk5KoIUJSBW6i/ZK7NceoAVZpE8qYMumvSWC62g82l+sBtLjVxjm6m2Uv0ZWPUhbfBpCeBPC5kTEV2C777b6Zr6JhzPRYcXvbGyB5/qHP0Qi4ZusTOeSoTZfwaXmYNkSFvmXAk2XNfIZXaruH7FOLNTeXxb7BaiSzwFMziBO59KECgYBj4pMrv9WsGuARRBR+J4wSL4biYpiB2fBRpdZifdxAa2X7/HvpMEv1hm/itRv1Xq8Ie+bzuXJO7b3uFhw+YY3eLOTpoNY3YXYBAFXZkWlGAmqd3948jVr0hDzCDAW58lKInQVx+PPgsVtcAjTT9iwLpXDGM5CYlPh+bLevjsuErg==",
        //异步通知地址
        'notify_url' => "http://www.kaoben.top/order-info/alinotify",
        //同步跳转
        'return_url' => "http://www.kaoben.top/user/orders",
        //编码格式
        'charset' => "UTF-8",
        //签名方式
        'sign_type'=>"RSA2",
        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlsMy4YNmu5xPm/lp82k8HexDX2TwTsGcxZhpJgvg1lSKcNostKH5/q6upAY/iuNZI3YkMbF2pJdjli2Y+bSFe4TtGUnkx38aeSXKeNZ9uSvVzn6CzKQaz3NZxgoCtNnl4pONgfh3pEllfkGTzadjM/tfSBfvlvIZkxKvklDEVybcKSqfqRAu2OiAk8QjrlQ5qSymTMIgcnuMMCchOYJuGItWh7TJ8+osDJyO5X/Nw2SMVrdWN3s9MXPpee6oz0ZMEQ7QzykQR+P/FuVIMsKEjPm2bd0eKjO17cr0gFjLeRtkwy6Wzv36In8gWcTWSNycYmhxKADfuKPxkadtSj6c6wIDAQAB",
    ],
    'wxpay' => [
        //异步通知地址
        'notify_url' => "https://www.kaoben.top/wxnotify",
        // 获取session_key, openid接口
        'jscode2session_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=$xcx_appid&secret=$xcx_secret&js_code=%s&grant_type=authorization_code",
        
        
    ],
];
