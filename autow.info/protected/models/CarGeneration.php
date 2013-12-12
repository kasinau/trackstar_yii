<?php

/**
 * This is the model class for table "car_generation".
 *
 * The followings are the available columns in table 'car_generation':
 * @property integer $id
 * @property integer $car_model_id
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property string $name
 * @property string $production_period
 * @property string $production_from
 * @property string $production_to
 * @property string $description
 * @property string $image
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Article[] $articles
 * @property CarModel $carModel
 */
class CarGeneration extends AutoWActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarGeneration the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'car_generation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('car_model_id, name, production_from', 'required'),
			array('car_model_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('production_period', 'length', 'max'=>20),
			array('production_from', 'length', 'max'=>20),
			array('production_to', 'length', 'max'=>20),
            array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, car_model_id, name, production_period, production_from, production_to', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'articles' => array(self::HAS_MANY, 'Article', 'car_generation_id'),
			'carModel' => array(self::BELONGS_TO, 'CarModel', 'car_model_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'car_model_id' => 'Car Model',
			'name' => 'Name',
			'production_period' => 'Production Period',
			'production_from' => 'Production From',
			'production_to' => 'Production To',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('car_model_id',$this->car_model_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('production_period',$this->production_period,true);
		$criteria->compare('production_from',$this->production_from,true);
		$criteria->compare('production_to',$this->production_to,true);
        $criteria->condition = 'car_model_id=:carModelID';
        $criteria->params = array(':carModelID' => $this->car_model_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}