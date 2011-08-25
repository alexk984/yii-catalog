<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
	return array(
		'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
		'name' => 'Yii catalog',
		'charset' => 'UTF-8',
		'sourceLanguage' => 'en_US',
		'language' => 'ru',
		// preloading 'log' component
		'preload' => array('log'),
        'defaultController'=>'Catalog',
		// autoloading model and component classes
		'import' => array(
			'application.models.*',
			'application.components.*',
			'application.modules.user.models.*',
			'application.modules.user.components.*',
			'application.helpers.*',
			'ext.shoppingCart.*',
			'application.widgets.*',
		),
		'modules' => array(
			// uncomment the following to enable the Gii tool

			'gii' => array(
				'class' => 'system.gii.GiiModule',
				'password' => 'alex',
			),
			'admin',
			'user',
		),
		// application components
		'components' => array(
			'shoppingCart' =>
			array(
				'class' => 'EShoppingCart',
			),
			'user' => array(
				// enable cookie-based authentication
				'allowAutoLogin' => true,
				'loginUrl' => array('/user/login'),
			),
			// uncomment the following to enable URLs in path-format
			'urlManager' => array(
				'urlFormat' => 'path',
				'rules' => array(
                    'catalog/search' => 'catalog/search',
					'catalog/<name:[\w-]+>' => 'catalog/view',
					'catalog/goods/<id:\d+>' => 'catalog/view',
					'catalog' => 'catalog/index',
					'pages/<name:\w+>'=>'site/page/view/<name>',
					'<controller:\w+>/<id:\d+>' => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				),
				'showScriptName' => FALSE,
			),
			'db' => array(
				'connectionString' => 'mysql:host=localhost;dbname=yii-catalog',
				'username' => 'root',
				'password' => '',
				'emulatePrepare' => true,
				'charset' => 'utf8',
				'tablePrefix' => '',
				'enableProfiling' => true,
				'enableParamLogging' => true,
				'schemaCachingDuration'=>'3600'
			),
			'errorHandler' => array(
				// use 'site/error' action to display errors
				'errorAction' => 'site/error',
			),
			'log' => array(
				'class' => 'CLogRouter',
				'routes' => array(
					array(
						'class' => 'CFileLogRoute',
						'levels' => 'error, warning',
					),
					// uncomment the following to show log messages on web pages
					array(
						'class' => 'CWebLogRoute',
						'showInFireBug' => false,
						'categories' => 'system.db.CDbCommand',
					),
				),
			),
			'image' => array(
				'class' => 'application.extensions.image.CImageComponent',
				// GD or ImageMagick
				'driver' => 'GD',
				// ImageMagick setup path
				'params' => array('directory' => '/opt/local/bin'),
			),
			'cache' => array(
//				'class' => 'system.caching.CMemCache',
				//'class' => 'ext.redis.CRedisCache',
//				'servers' => array(
//					array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 60),
//				),
				'class' => 'system.caching.CDummyCache',
			),
		),
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params' => array(
			// this is used in contact page
			'adminEmail' => 'webmaster@example.com',
		),
	);