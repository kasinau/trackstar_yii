<?php

class CarBrandController extends Controller
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
        $carModelDataProvider = new CActiveDataProvider(
            'CarModel',
            array(
                'criteria' => array(
                    'condition' => 'car_brand_id=:carBrandId',
                    'params' => array(':carBrandId' => $id),
                ),
                'pagination' => array(
                    'pageSize' => 1,
                ),
            )
        );
		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'carModelDataProvider' => $carModelDataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        if (!Yii::app()->user->checkAccess('createCarBrand')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

		$model=new CarBrand;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CarBrand']))
		{
			$model->attributes=$_POST['CarBrand'];
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
        if (!Yii::app()->user->checkAccess('updateCarBrand')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CarBrand']))
		{
			$model->attributes=$_POST['CarBrand'];
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
        if (!Yii::app()->user->checkAccess('deleteCarBrand')) {
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
		$dataProvider=new CActiveDataProvider('CarBrand');
        Yii::app()->clientScript->registerLinkTag(
            'alternate',
            'application/rss+xml',
            $this->createUrl('comment/feed')
        );
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        if (!Yii::app()->user->checkAccess('updateCarBrand') ||
            !Yii::app()->user->checkAccess('deleteCarBrand')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

		$model=new CarBrand('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CarBrand']))
			$model->attributes=$_GET['CarBrand'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CarBrand the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CarBrand::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CarBrand $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='car-brand-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
