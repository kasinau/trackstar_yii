<?php

/**
 * database data  account:
 * service: http://www.freesqldatabase.com
 * account: kasinau@mail.ru
 *
 */

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'components'=>array(
            'fixture'=>array(
                'class'=>'system.test.CDbFixtureManager',
            ),
//			 uncomment the following to provide test database connection
            'db'=>array(
                'connectionString'=>'mysql:host=sql4.freesqldatabase.com;dbname=sql419916',
                'emulatePrepare' => true,
                'username' => 'sql419916',
                'password' => 'hG9!pB6%',
                'charset' => 'utf8',
            ),

        ),
    )
);
