<?php

$config = [
    'id' => 'newsportal',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_27F8Dy61CEZ-pvZXe7dTyZdkb4_qchZ',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => require(__DIR__ . '/routes.php'),
		'view' => [
			'class' => 'app\components\View',
		],
		'mailer' => [
			'class' => 'zyx\phpmailer\Mailer',
			'viewPath' => realpath(__DIR__ . '/../views') . '/mail',
			'useFileTransport' => false,
			'config' => [
				'mailer' => 'smtp',
				'host' => 'smtp.gmail.com',
				'port' => '465',
				'smtpsecure' => 'ssl',
				'smtpauth' => true,
				'username' => 'teste@konnng.com',
				'password' => 'sj-bh-until-dreg-ouzo-beggar',
			],
		],
    ],
    'params' => require(__DIR__ . '/params.php'),
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    	'allowedIPs' => ['*'],
    ];
}

return $config;
