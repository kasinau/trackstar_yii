<?php

/**
 * database data  account:
 * service: http://www.freesqldatabase.com
 * account: pavelco_r@yahoo.com
 *
 */

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'components'=>array(
            'fixture'=>array(
                'class'=>'system.test.CDbFixtureManager',
            ),
            'db' => array(
                'connectionString' => 'mysql:host=sql4.freesqldatabase.com;dbname=sql419913',
                'emulatePrepare' => true,
                'username' => 'sql419913',
                'password' => 'lC5*aH1*',
                'charset' => 'utf8',
            ),
        ),
    )
);