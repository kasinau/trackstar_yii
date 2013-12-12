<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 3/4/13
 * Time: 11:17 PM
 */
class UserTest extends CDbTestCase
{
//    public $fixtures = array(
//        'users' => 'User'
//    );
    public function testCRUD()
    {
        //Create a new user
        $newUser = new User();
        $newUserName = 'user 1';
        $newUser->setAttributes(
            array(
                'name' => $newUserName,
                'username' => 'username',
                'email' => 'email',
                'password' => MD5('username'),
                'role' => 'user',
                'description' => 'description',
                'image' => 'image',
                'create_time' => '2010-01-01 00:00:00',
                'update_time' => '2010-01-01 00:00:00',
            )
        );
        $this->assertTrue($newUser->save(false));

        //READ back the newly created user
        $retrievedUser=User::model()->findByPk($newUser->id);
        $this->assertTrue($retrievedUser instanceof User);
        $this->assertEquals($newUserName,$retrievedUser->name);

        //UPDATE the newly created user
        $updatedUserName = 'Updated Test User 1';
        $newUser->name = $updatedUserName;
        $this->assertTrue($newUser->save(false));

//        //read back the record again to ensure the update worked
//        $updatedUser=User::model()->findByPk($newUser->id);
//        $this->assertTrue($updatedUser instanceof User);
//        $this->assertEquals($updatedUserName,$updatedUser->name);
//
//        //DELETE the user
//        $newUserId = $newUser->id;
//        $this->assertTrue($newUser->delete());
//        $deletedUser=User::model()->findByPk($newUserId);
//        $this->assertEquals(NULL,$deletedUser);
    }
}