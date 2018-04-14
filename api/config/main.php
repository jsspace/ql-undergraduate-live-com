<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            //'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        /*'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],*/
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'site',
                    'pluralize'=>false,
                    'extraPatterns' => [
                        'GET index' => 'index'
                    ]
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'except' => ['delete', 'create', 'update', 'view'],
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST signup' => 'signup',
                        'POST logincode' => 'logincode',
                        'POST changepassword' => 'changepassword'
                    ]
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'audio',
                    'except' => ['delete', 'create', 'update', 'view'],
                    'extraPatterns' => [
                        'GET audio-home' => 'audio-home',
                        'GET get-audio' => 'get-audio',
                        'GET get-audiosection' => 'get-audiosection',
                    ]
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'card',
                    'extraPatterns' => [
                        'GET wechat-get-balance' => 'wechat-get-balance',
                        'POST wechat-recharge' => 'wechat-recharge',
                        'GET coin-details' => 'coin-details'
                    ]
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'personal',
                    'pluralize'=>false,
                    'extraPatterns' => [
                        'GET user-profile' => 'user-profile',
                        'POST update-username' => 'update-username',
                        'POST update-gender' => 'update-gender',
                        'POST update-headimg' => 'update-headimg',
                        'GET course-list' => 'course-list',
                        'GET order-list' => 'order-list',
                        'GET message-list' => 'message-list',
                        'POST message-view' => 'message-view'
                    ]
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'course',
                    'extraPatterns' => [
                        'GET college' => 'college',
                        'GET list' => 'list'
                    ]
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'order',
                    'pluralize'=>false,
                    'extraPatterns' => [
                        'POST shopping' => 'shopping',
                    ]
                ],
            ],
        ],
    ],
    'params' => $params
];
