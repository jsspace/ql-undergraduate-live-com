<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=47.104.216.133;dbname=fanghua',
            'username' => 'fanghua',
            'password' => 'fanghua@#$123',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
