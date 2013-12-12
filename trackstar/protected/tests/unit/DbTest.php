<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 2/24/13
 * Time: 10:29 PM
 */
class DbTest extends CTestCase
{
    public function testConnection()
    {
        $this->assertNotEquals(NULL, Yii::app()->db);
    }
}