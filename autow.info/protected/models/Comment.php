<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property integer $article_id
 * @property integer $user_id
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property string $comment
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Article $article
 * @property User $user
 */
class Comment extends AutoWActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
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
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comment', 'required'),
			array('id, article_id, user_id', 'numerical', 'integerOnly'=>true),
			array('comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, article_id, user_id, comment, create_time', 'safe', 'on'=>'search'),
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
			'article' => array(self::BELONGS_TO, 'Article', 'article_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'article_id' => 'Article',
			'user_id' => 'User',
			'comment' => 'Comment',
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
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @param int $limit
     * @param null $entity
     * @param null $propertyValue
     * @return array|CActiveRecord|mixed|null
     */
    public static function findRecentComments($limit = 10, $entity = null, $entity_id = null)
    {
        if ($entity != null && $entity_id != null) {
            switch ($entity) {
                case 'carBrandId' :
                    // get all comment form articles of a specific car brand...
                    $result = self::model()
                        ->with(
                            array(
                                'article' => array(
                                    'with' => array(
                                        'carGeneration' => array(
                                            'with' => array(
                                                'carModel' => array(
                                                    'condition' => 'car_brand_id=' . $entity_id,
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            )
                        )
                        ->findAll(
                            array(
                                'order' => 't.create_time DESC',
                                'limit' => $limit,
                            )
                        );
                    break;
                case 'carModelId' :
                    // get all comment form articles of a specific car model...
                    $result = self::model()
                        ->with(
                            array(
                                'article' => array(
                                    'with' => array(
                                        'carGeneration' => array(
                                            'condition' => 'car_model_id=' . $entity_id,
                                        ),
                                    ),
                                ),
                            )
                        )
                        ->findAll(
                            array(
                                'order' => 't.create_time DESC',
                                'limit' => $limit,
                            )
                        );
                    break;
                case 'carGenerationId' :
                    // get all comment form articles of a specific car model...
                    $result = self::model()
                        ->with(
                            array(
                                'article' => array(
                                    'condition' => 'car_generation_id=' . $entity_id,
                                ),
                            )
                        )
                        ->findAll(
                            array(
                                'order' => 't.create_time DESC',
                                'limit' => $limit,
                            )
                        );
                    break;
                case 'articleId' :
                    // get all comment form articles of a specific car model...
                    $result = self::model()
                        ->with(
                            array(
                                'article' => array(
                                    'condition' => 'article.id=' . $entity_id,
                                ),
                            )
                        )
                        ->findAll(
                            array(
                                'order' => 't.create_time DESC',
                                'limit' => $limit,
                            )
                        );
                    break;
                default :
                    // get all comment across all articles...
                    $result = self::model()
                        ->with(
                            array(
                                'article' => array(
                                    'with' => array(
                                        'carGeneration' => array(
                                            'with' => array(
                                                'carModel' => array(
                                                    'with' => 'carBrand'
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            )
                        )
                        ->findAll(
                            array(
                                'order' => 't.create_time DESC',
                                'limit' => $limit,
                            )
                        );
            }
        } else {
            // get all comment across all articles...
            $result = self::model()
                ->with(
                    array(
                        'article' => array(
                            'with' => array(
                                'carGeneration' => array(
                                    'with' => array(
                                        'carModel' => array(
                                            'with' => 'carBrand'
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    )
                )
                ->findAll(
                    array(
                        'order' => 't.create_time DESC',
                        'limit' => $limit,
                    )
                );
        }

        return $result;
    }
}