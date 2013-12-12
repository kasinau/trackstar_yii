<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'theme' => 'new',
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Auto World',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.modules.admin.models.*',
    ),

    'modules'=>array(
        // uncomment the following to enable the Gii tool

        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'admin',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
        'admin',

    ),

    // application components
    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => false,
            'rules'=>array(
                'all-brands' => 'carBrand/index',
                'manage-brands' => 'carBrand/admin',
                'create-brand' => 'carBrand/create',
                'brands' => 'carBrand',
                'brand/<car_brand_id:\d+>/models' => 'carModel/index',
                'brand/<id:\d+>' => 'carBrand/view',
                'delete-brand/<id:\d+>' => 'carBrand/delete',
                'update-brand/<id:\d+>' => 'carBrand/update',
                'model/<id:\d+>' => 'carModel/view',
                'model/<car_model_id:\d+>/generations' => 'carGeneration/index',
                'model/create/<car_brand_id:\d+>' => 'carModel/create',
                'delete-model/<id:\d+>' => 'carModel/delete',
                'update-model/<id:\d+>' => 'carModel/update',
                'manage-models/<car_brand_id:\d+>' => 'carModel/admin',
                'generation/<id:\d+>' => 'carGeneration/view',
                'generation/<car_generation_id:\d+>/articles' => 'article/index',
                'generation/create/<car_model_id:\d+>' => 'carGeneration/create',
                'delete-generation/<id:\d+>' => 'carGeneration/delete',
                'update-generation/<id:\d+>' => 'carGeneration/update',
                'manage-generations/<car_model_id:\d+>' => 'carGeneration/admin',
                'article/<id:\d+>' => 'article/view',
                'article/<article_id:\d+>/comments' => 'comment/index',
                'article/create/<car_generation_id:\d+>' => 'article/create',
                'delete-article/<id:\d+>' => 'article/delete',
                'update-article/<id:\d+>' => 'article/update',
                'manage-articles/<car_generation_id:\d+>' => 'article/admin',
                'comment/<id:\d+>' => 'comment/view',
                'comment/create/<article_id:\d+>' => 'comment/create',
                'delete-comment/<id:\d+>' => 'comment/delete',
                'update-comment/<id:\d+>' => 'comment/update',
                'manage-comments/<article_id:\d+>' => 'comment/admin',
                '<entity:\w+>/<id:\d+>/comment-feed' => array(
                    'comment/feed',
                    'urlSuffix' => '.xml',
                    'caseSensitive' => false,
                ),
                'comment-feed' => array(
                    'comment/feed',
                    'urlSuffix' => '.xml',
                    'caseSensitive' => false,
                ),
//                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),

//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
        // uncomment the following to use a MySQL database

        /**
         * database data  account:
         * service: http://www.freesqldatabase.com
         * account: r.pavelco@gmail.com
         *
         */
        'db'=>array(
            'connectionString' => 'mysql:host=sql4.freesqldatabase.com;dbname=sql419912',
            'emulatePrepare' => true,
            'username' => 'sql419912',
            'password' => 'zT6!xT9!',
            'charset' => 'utf8',
        ),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info, trace',
                    'logFile' => 'infoMessages.log',
                ),
                array(
                    'class'=>'CWebLogRoute',
                    'levels' => 'warning',
                ),

            ),
        ),

        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
        ),

        // caching data
        'cache' => array(
            'class' => 'system.caching.CFileCache',
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@example.com',
    ),

);