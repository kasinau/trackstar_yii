<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rpavelco
 * Date: 12/11/13
 * Time: 11:10 AM
 */

class SysMessageTest extends CDbTestCase
{
    public $fixtures = array(
        'messages' => 'SysMessage',
    );

    public function testGetLatest()
    {
        $message = SysMessage::getLatest();
        $this->assertTrue($message instanceof SysMessage);
    }
}