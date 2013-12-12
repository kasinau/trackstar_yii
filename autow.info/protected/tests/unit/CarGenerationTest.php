<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 3/4/13
 * Time: 11:17 PM
 */
class CarGenerationTest extends CDbTestCase
{
    public $fixtures = array(
        'car_generations' => 'CarGeneration'
    );
    public function testCRUD()
    {
        //Create a new car generation
        $newCarGeneration = new CarGeneration();
        $newCarGenerationName = 'Test CarGeneration 1';
        $newCarGeneration->setAttributes(
            array(
                'car_model_id' => 1,
                'name' => $newCarGenerationName,
                'production_period' => '1988-1994',
                'production_from' => 1998,
                'production_to' => 2004,
            )
        );
        $this->assertTrue($newCarGeneration->save(false));

        //READ back the newly created car generation
        $retrievedCarGeneration=CarGeneration::model()->findByPk($newCarGeneration->id);
        $this->assertTrue($retrievedCarGeneration instanceof CarGeneration);
        $this->assertEquals($newCarGenerationName,$retrievedCarGeneration->name);

        //UPDATE the newly created car generation
        $updatedCarGenerationName = 'Updated Test CarGeneration 1';
        $newCarGeneration->name = $updatedCarGenerationName;
        $this->assertTrue($newCarGeneration->save(false));

        //read back the record again to ensure the update worked
        $updatedCarGeneration=CarGeneration::model()->findByPk($newCarGeneration->id);
        $this->assertTrue($updatedCarGeneration instanceof CarGeneration);
        $this->assertEquals($updatedCarGenerationName,$updatedCarGeneration->name);

        //DELETE the car generation
        $newCarGenerationId = $newCarGeneration->id;
        $this->assertTrue($newCarGeneration->delete());
        $deletedCarGeneration=CarGeneration::model()->findByPk($newCarGenerationId);
        $this->assertEquals(NULL,$deletedCarGeneration);
    }
}