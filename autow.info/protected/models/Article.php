<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $id
 * @property integer $car_generation_id
 * @property integer $user_id
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property string $title
 * @property string $content
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property User $user
 * @property CarGeneration $carGeneration
 * @property Photo[] $photos
 */
class Article extends AutoWActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Article the static model class
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
		return 'article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('car_generation_id', 'required'),
			array('car_generation_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>200),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, car_generation_id, user_id, title, content, create_time, update_time', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'carGeneration' => array(self::BELONGS_TO, 'CarGeneration', 'car_generation_id'),
			'photos' => array(self::HAS_MANY, 'Photo', 'article_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'article_id'),
            'commentCount' => array(self::STAT, 'Comment', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'car_generation_id' => 'Car Generation',
			'user_id' => 'User',
			'title' => 'Title',
			'content' => 'Content',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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
		$criteria->compare('car_generation_id',$this->car_generation_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
        $criteria->condition = 'car_generation_id=:carGenerationID';
        $criteria->params = array(':carGenerationID' => $this->car_generation_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * Prepares create_time, update_time and user_id
     * attributes before performing validation.
     */
    protected function beforeValidate()
    {
        if ($this->isNewRecord) {
            /**
             * set the create date, last updated date and
             * the user doing the creating
             */
            $this->create_time = $this->update_time = new CDbExpression('NOW()');
            $this->user_id = Yii::app()->user->id;
        } else {
            /**
             * not a new record, so just set the last updated time
             * and last updated user id
             */
            $this->update_time = new CDbExpression('NOW()');
        }

        return parent::beforeValidate();
    }

    /**
     * @param $comment
     * @return mixed
     *
     * Adds a comment to this article
     */
    public function addComment($comment)
    {
        $comment->article_id = $this->id;
        $comment->user_id = Yii::app()->user->id;
        $comment->create_time = new CDbExpression('NOW()');
        return $comment->save();
    }
}