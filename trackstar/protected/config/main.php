<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'theme' => 'new',
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'TrackStar',
    'homeUrl'=>'/trackstar/project',

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
                'project/<pid:\d+>/issues' => 'issue/index',
                'project/update/<id:\d+>' => 'project/update',
                'project/<id:\d+>' => 'project/view',
                'issue/<id:\d+>/*' => 'issue/view',
                '<pid:\d+>/commentfeed' => array(
                    'comment/feed',
                    'urlSuffix' => '.xml',
                    'caseSensitive' => false,
                ),
                'commentfeed' => array(
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
         * account: ravel@list.ru         *
         */

        'db'=>array(
            'connectionString' => 'mysql:host=sql4.freesqldatabase.com;dbname=sql419915',
            'emulatePrepare' => true,
            'username' => 'sql419915',
            'password' => 'cG3!wT5*',
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