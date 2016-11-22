<?php 

return [
	'enablePrettyUrl' => true,
	'showScriptName' => false,
	'rules' => [
		'/login' => '/site/login',
		'/logout' => '/site/logout',
		'/register' => '/site/register',
		'/change-password' => '/site/change-password',
		'/submit-article' => '/site/submit-article',
		'/my-articles' => '/site/my-articles',
		'/articles' => '/site/articles',
		'/article/<id:\d+>' => '/site/article',
		'/article/download/<id:\d+>' => '/site/article-download',
		'/article/<action:delete>/<id:\d+>' => '/site/article-admin',
		'/article/<action:approve>/<id:\d+>' => '/site/article-admin',
		'/article/<action:disable>/<id:\d+>' => '/site/article-admin',
		'/rss.xml' => '/site/rss',
	],
];