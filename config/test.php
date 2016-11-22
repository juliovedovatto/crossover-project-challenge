<?php
/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
	'bootstrap' => ['log'],
    'basePath' => dirname(__DIR__),    
    'language' => 'en-US',
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
    	'urlManager' => require(__DIR__ . '/routes.php'),
        'user' => [
            'identityClass' => 'app\models\User',
        ],        
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
   		'log' => [
			'traceLevel' => 3,
   			'targets' => [
   				[ 'class'  => 'yii\log\FileTarget', 'levels' => ['error', 'warning'], 'logFile' => '@app/runtime/logs/unit_testing.error.log', ],
   			],
   		],
		'view' => [
    		'class' => 'app\components\View',
    	],
    ],
    'params' => require(__DIR__ . '/params.php'),
];
