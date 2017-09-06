<?php
//权限配置参考 http://www.manks.top/yii2-frame-rbac-template.html
// https://www.kancloud.cn/curder/yii/247759
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
//         'user' => [
//             'class' => 'dektrium\user\Module',
//             'enableConfirmation' => fase,//注册时不进行邮箱认证
//             'emailChangeStrategy' => 'STRATEGY_INSECURE',//当用户的邮箱改变时，不进行认证
//             'admins' => ['admin'],//有权限操作用户
//         ],
        'admin' => [
            'class' => 'mdm\admin\Module',
//              'layout' => 'left-menu',//yii2-admin的导航菜单
        ]
    ],
    "aliases" => [
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
            'defaultRoles' => ["guest"],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            "enableCsrfValidation"=>false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            //用于表明urlManager是否启用URL美化功能，在Yii1.1中称为path格式URL，    
            // Yii2.0中改称美化。   
            // 默认不启用。但实际使用中，特别是产品环境，一般都会启用。   
            "enablePrettyUrl" => true,    
            // 是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，    
            // 否则认为是无效路由。    
            // 这个选项仅在 enablePrettyUrl 启用后才有效。    
            "enableStrictParsing" => false,    
            // 是否在URL中显示入口脚本。是对美化功能的进一步补充。    
            "showScriptName" => false,    
            // 指定续接在URL后面的一个后缀，如 .html 之类的。仅在 enablePrettyUrl 启用时有效。    
            "suffix" => "",    
            "rules" => [        
                "<controller:\w+>/<id:\d+>"=>"<controller>/view",  
                "<controller:\w+>/<action:\w+>"=>"<controller>/<action>"    
            ],
        ],
        
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',//允许访问的节点，可自行添加
            'admin/*',//允许所有人访问admin节点及其子节点
            'gii/*',
            'debug/*',
            'user/*',
            'course/*',
            'course-category/*',
            'course-chapter/*',
            'course-section/*',
            'course-package-category/*',
            'course-package/*',
            'friendly-links/*',
            'hot-category/*',
        ]
    ],
    'params' => $params,
];
