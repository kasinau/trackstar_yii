<?php

class CarModelController extends Controller
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
            'carBrandContext + create index admin', //check to ensure valid car brand context
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
        $model = $this->loadModel($id);
        $carGenerationDataProvider = new CActiveDataProvider(
            'CarGeneration',
            array(
                'criteria' => array(
                    'condition' => 'car_model_id=:carModelId',
                    'params' => array(':carModelId' => $id),
                ),
                'pagination' => array(
                    'pageSize' => 1,
                ),
            )
        );
		$this->render('view',array(
			'model' => $model,
			'carGenerationDataProvider'=>$carGenerationDataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        if (!Yii::app()->user->checkAccess('createCarModel')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

		$model=new CarModel;
        $model->car_brand_id = $this->_car_brand->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CarModel']))
		{
			$model->attributes=$_POST['CarModel'];
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
        if (!Yii::app()->user->checkAccess('updateCarModel')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CarModel']))
		{
			$model->attributes=$_POST['CarModel'];
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
        if (!Yii::app()->user->checkAccess('deleteCarModel')) {
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
            'CarModel',
            array(
                'criteria' => array(
                    'condition' => 'car_brand_id=:carBrandId',
                    'params' => array(
                        ':carBrandId' => $this->_car_brand->id,
                    ),
                ),
            )
        );
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
            'carBrand' => $this->_car_brand,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        if (!Yii::app()->user->checkAccess('updateCarModel') ||
            !Yii::app()->user->checkAccess('deleteCarModel')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

		$model=new CarModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CarModel']))
			$model->attributes=$_GET['CarModel'];

        $model->car_brand_id = $this->_car_brand->id;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CarModel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CarModel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CarModel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='car-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * In-class defined filter method, configured for use in the above filters() method
     * It is called before the actionCreate() action method is run in order to ensure a proper car brand context
     * @param $filterChain
     */
    public function filterCarBrandContext($filterChain)
    {
        //set the car brand identifier based on either the get or post input
        //request variables, since we allow both types for our actions
        $car_brand_id = isset($_GET['car_brand_id']) ?
            $_GET['car_brand_id'] : (isset($_POST['car_brand_id']) ? $_POST['car_brand_id'] : null);
        $this->loadCarBrand($car_brand_id);
        //complete the running of other filters and execute the requested action
        $filterChain->run();
    }

    /**
     * @var private property containing the associated CarBrand model instance
     */
    private $_car_brand = null;

    /**
     * Protected method to load the associated CarBrand model class
     * @car_brand_id the primary identifier of the associated CarBrand
     * @return object the CarBrand data model based on the primary key
     */
    protected function loadCarBrand($car_brand_id)
    {
        //if the car_brand property is null, create it based on input id
        if ($this->_car_brand === null) {
            $this->_car_brand = CarBrand::model()->findByPk($car_brand_id);
            if ($this->_car_brand === null) {
                throw new CHttpException(404, 'the requested car brand does not exist.');
            }
        }
        return $this->_car_brand;
    }
}
