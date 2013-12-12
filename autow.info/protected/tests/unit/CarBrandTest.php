<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 3/4/13
 * Time: 11:17 PM
 */
class CarBrandTest extends CDbTestCase
{
    public $fixtures = array(
        'car_brands' => 'CarBrand'
    );
    public function testCRUD()
    {
        //Create a new car brand
        $newCarBrand = new CarBrand();
        $newCarBrandName = 'CarBrand 1';
        $newCarBrand->setAttributes(
            array(
                'name' => $newCarBrandName,
                'logo' => 'Logo for car brand 1',
            )
        );
        $this->assertTrue($newCarBrand->save(false));

        //READ back the newly created car brand
        $retrievedCarBrand=CarBrand::model()->findByPk($newCarBrand->id);
        $this->assertTrue($retrievedCarBrand instanceof CarBrand);
        $this->assertEquals($newCarBrandName,$retrievedCarBrand->name);

        //UPDATE the newly created car brand
        $updatedCarBrandName = 'Updated Test CarBrand 1';
        $newCarBrand->name = $updatedCarBrandName;
        $this->assertTrue($newCarBrand->save(false));

        //read back the record again to ensure the update worked
        $updatedCarBrand=CarBrand::model()->findByPk($newCarBrand->id);
        $this->assertTrue($updatedCarBrand instanceof CarBrand);
        $this->assertEquals($updatedCarBrandName,$updatedCarBrand->name);

        //DELETE the car brand
        $newCarBrandId = $newCarBrand->id;
        $this->assertTrue($newCarBrand->delete());
        $deletedCarBrand=CarBrand::model()->findByPk($newCarBrandId);
        $this->assertEquals(NULL,$deletedCarBrand);
    }
}