<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    "modules" => [
        "admin" => [
            "class" => "mdm\admin\Module",
        ],
    ],
    "aliases" => [
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
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
//        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
//            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning','info'],
//                ],
//            ],
//        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => '1350130****@163.com',//真实的163邮箱地址
                'password' => '********', //真实的邮箱密码
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['1350130****@163.com'=>'admin'],
            ],
        ],
        'log' => [
            'traceLevel'=> YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info','trace'],
                ],
                [
                    'class'=> 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['rhythmk'],
                    'logFile' => '@app/runtime/logs/Mylog/requests.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

        // "urlManager" => [    
        //     //用于表明urlManager是否启用URL美化功能，在Yii1.1中称为path格式URL，    
        //     // Yii2.0中改称美化。   
        //     // 默认不启用。但实际使用中，特别是产品环境，一般都会启用。   
        //     "enablePrettyUrl" => true,    
        //     // 是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，    
        //     // 否则认为是无效路由。    
        //     // 这个选项仅在 enablePrettyUrl 启用后才有效。    
        //     "enableStrictParsing" => false,    
        //     // 是否在URL中显示入口脚本。是对美化功能的进一步补充。    
        //     "showScriptName" => false,    
        //     // 指定续接在URL后面的一个后缀，如 .html 之类的。仅在 enablePrettyUrl 启用时有效。    
        //     "suffix" => "",    
        //     "rules" => [        
        //         "<controller:\w+>/<id:\d+>"=>"<controller>/view",  
        //         "<controller:\w+>/<action:\w+>"=>"<controller>/<action>"    
        //     ],
        // ],        
    ],
    'params' => $params,
];
