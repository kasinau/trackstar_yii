<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $description
 * @property string $image
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Article[] $articles
 */
class User extends AutoWActiveRecord
{
    /**
     * @var string
     */
    public $password_repeat;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, password', 'required'),
			array('name, username, email, password', 'length', 'max'=>128),
			array('role', 'length', 'max'=>20),
            array('email, username', 'unique'),
            array('password', 'compare'),
            array('password_repeat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, username, email, password, role, create_time', 'safe', 'on'=>'search'),
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
			'articles' => array(self::HAS_MANY, 'Article', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'role' => 'Role',
			'create_time' => 'Create Time',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * Prepares create_time attributes before performing validation.
     */
    protected function beforeValidate()
    {
        if ($this->isNewRecord) {
            /**
             * set the create date
             */
            $this->create_time = new CDbExpression('NOW()');
            if (!$this->role) {
                $this->role = 'user';
            }
        }

        return parent::beforeValidate();
    }

    /**
     * perform one-way encryption on the password before we store it in the database
     */
    protected function afterValidate()
    {
        parent::afterValidate();
        $this->password = $this->encrypt($this->password);
    }

    /**
     * @param $value
     * @return string
     */
    public function encrypt($value)
    {
        return md5($value);
    }

    /**
     * @return bool
     * Save a new user and after saving him insert the rbac data into the AuthAssignment database table
     */
    public function save($runValidation=true,$attributes=null)
    {
        $return_parent = parent::save($runValidation, $attributes);
        if ($return_parent) {
            $assignedToRole = $this->_authmanager->isAssigned($this->role, $this->id);
            $assignments = $this->_authmanager->getAuthAssignments($this->id);
            $this->_authmanager->assign($this->role,$this->id);
            $this->_authmanager->up;
        }
        return $return_parent;
    }

    /**
     * @return bool
     * Delete a user and after deleting him delete the rbac data from the AuthAssignment database table
     */
    public function delete()
    {
        $return_parent = parent::delete();
        if ($return_parent) {
            $this->_authmanager->revoke($this->role,$this->id);
        }
        return $return_parent;
    }
}