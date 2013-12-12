<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 3/4/13
 * Time: 11:17 PM
 */
class PhotoTest extends CDbTestCase
{
    public $fixtures = array(
        'photos' => 'Photo'
    );
    public function testCRUD()
    {
        //Create a new photo
        $newPhoto = new Photo();
        $newPhotoName = 'Test Photo 1';
        $newPhoto->setAttributes(
            array(
                'article_id' => 1,
                'photo_order_number' => 1,
                'name' => $newPhotoName,
            )
        );
        $this->assertTrue($newPhoto->save(false));

        //READ back the newly created photo
        $retrievedPhoto=Photo::model()->findByPk($newPhoto->id);
        $this->assertTrue($retrievedPhoto instanceof Photo);
        $this->assertEquals($newPhotoName,$retrievedPhoto->name);

        //UPDATE the newly created photo
        $updatedPhotoName = 'Updated Test Photo 1';
        $newPhoto->name = $updatedPhotoName;
        $this->assertTrue($newPhoto->save(false));

        //read back the record again to ensure the update worked
        $updatedPhoto=Photo::model()->findByPk($newPhoto->id);
        $this->assertTrue($updatedPhoto instanceof Photo);
        $this->assertEquals($updatedPhotoName,$updatedPhoto->name);

        //DELETE the photo
        $newPhotoId = $newPhoto->id;
        $this->assertTrue($newPhoto->delete());
        $deletedPhoto=Photo::model()->findByPk($newPhotoId);
        $this->assertEquals(NULL,$deletedPhoto);
    }
}