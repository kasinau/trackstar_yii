<?php

class CarGenerationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'carModelContext + create index admin', //check to ensure valid car model context
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin', 'r.pavelco'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $articleDataProvider = new CActiveDataProvider(
            'Article',
            array(
                'criteria' => array(
                    'condition' => 'car_generation_id=:carGenerationId',
                    'params' => array(':carGenerationId' => $id),
                ),
                'pagination' => array(
                    'pageSize' => 1,
                ),
            )
        );
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'articleDataProvider'=>$articleDataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        if (!Yii::app()->user->checkAccess('createCarGeneration')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=new CarGeneration;
        $model->car_model_id = $this->_car_model->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CarGeneration']))
		{
			$model->attributes=$_POST['CarGeneration'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        if (!Yii::app()->user->checkAccess('updateCarGeneration')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CarGeneration']))
		{
			$model->attributes=$_POST['CarGeneration'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        if (!Yii::app()->user->checkAccess('deleteCarGeneration')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider(
            'CarGeneration',
            array(
                'criteria' => array(
                    'condition' => 'car_model_id=:carModelId',
                    'params' => array(
                        ':carModelId' => $this->_car_model->id,
                    ),
                ),
            )

        );
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'carModel'=>$this->_car_model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        if (!Yii::app()->user->checkAccess('updateCarGeneration') ||
            !Yii::app()->user->checkAccess('deleteCarGeneration')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=new CarGeneration('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CarGeneration']))
			$model->attributes=$_GET['CarGeneration'];

        $model->car_model_id - $this->_car_model->id;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CarGeneration the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CarGeneration::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CarGeneration $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='car-generation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * In-class defined filter method, configured for use in the above filters() method
     * It is called before the actionCreate() action method is run in order to ensure a proper car model context
     * @param $filterChain
     */
    public function filterCarModelContext($filterChain)
    {
        //set the car model identifier based on either the get or post input
        //request variables, since we allow both types for our actions
        $car_model_id = isset($_GET['car_model_id']) ?
            $_GET['car_model_id'] : (isset($_POST['car_model_id']) ? $_POST['car_model_id'] : null);
        $this->loadCarModel($car_model_id);
        //complete the running of other filters and execute the requested action
        $filterChain->run();
    }

    /**
     * @var private property containing the associated CarModel model instance
     */
    private $_car_model = null;

    /**
     * Protected method to load the associated CarModel model class
     * @car_model_id the primary identifier of the associated CarBrand
     * @return object the CarModel data model based on the primary key
     */
    protected function loadCarModel($car_model_id)
    {
        //if the car_model property is null, create it based on input id
        if ($this->_car_model === null) {
            $this->_car_model = CarModel::model()->findByPk($car_model_id);
            if ($this->_car_model === null) {
                throw new CHttpException(404, 'the requested car model does not exist.');
            }
        }
        return $this->_car_model;
    }
}
