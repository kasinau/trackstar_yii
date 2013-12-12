<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 3/4/13
 * Time: 11:17 PM
 */
class CarModelTest extends CDbTestCase
{
    public $fixtures = array(
        'car_models' => 'CarModel'
    );
    public function testCRUD()
    {
        //Create a new model
        $newCarModel = new CarModel();
        $newCarModelName = 'Test Model 1';
        $newCarModel->setAttributes(
            array(
                'car_brand_id' => 1,
                'name' => $newCarModelName,
            )
        );
        $this->assertTrue($newCarModel->save(false));

        //READ back the newly created car
        $retrievedCarModel=CarModel::model()->findByPk($newCarModel->id);
        $this->assertTrue($retrievedCarModel instanceof CarModel);
        $this->assertEquals($newCarModelName,$retrievedCarModel->name);

        //UPDATE the newly created car
        $updatedCarModelName = 'Updated Test car 1';
        $newCarModel->name = $updatedCarModelName;
        $this->assertTrue($newCarModel->save(false));

        //read back the record again to ensure the update worked
        $updatedCarModel=CarModel::model()->findByPk($newCarModel->id);
        $this->assertTrue($updatedCarModel instanceof CarModel);
        $this->assertEquals($updatedCarModelName,$updatedCarModel->name);

        //DELETE the car
        $newCarModelId = $newCarModel->id;
        $this->assertTrue($newCarModel->delete());
        $deletedCarModel=CarModel::model()->findByPk($newCarModelId);
        $this->assertEquals(NULL,$deletedCarModel);
    }
}