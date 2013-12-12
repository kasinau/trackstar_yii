<?php

class PhotoController extends Controller
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
            'articleContext + create index admin', //check to ensure valid article context
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        if (!Yii::app()->user->checkAccess('createPhoto')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=new Photo;
        $model->article_id = $this->_article->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Photo']))
		{
			$model->attributes=$_POST['Photo'];
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
        if (!Yii::app()->user->checkAccess('updatePhoto')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Photo']))
		{
			$model->attributes=$_POST['Photo'];
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
        if (!Yii::app()->user->checkAccess('deletePhoto')) {
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
            'Photo',
            array(
                'criteria' => array(
                    'condition' => 'article_id=:articleId',
                    'params' => array(
                        ':articleId' => $this->_article->id,
                    ),
                ),
            )

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
        if (!Yii::app()->user->checkAccess('updatePhoto') ||
            !Yii::app()->user->checkAccess('deletePhoto')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=new Photo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Photo']))
			$model->attributes=$_GET['Photo'];

        $model->article_id = $this->_article->id;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Photo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Photo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Photo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='photo-form')
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
    public function filterArticleContext($filterChain)
    {
        //set the car brand identifier based on either the get or post input
        //request variables, since we allow both types for our actions
        $article_id = isset($_GET['article_id']) ?
            $_GET['article_id'] : (isset($_POST['article_id']) ? $_POST['article_id'] : null);
        $this->loadArticle($article_id);
        //complete the running of other filters and execute the requested action
        $filterChain->run();
    }

    /**
     * @var private property containing the associated Article model instance
     */
    private $_article = null;

    /**
     * Protected method to load the associated Article model class
     * @article_id the primary identifier of the associated Article
     * @return object the Article data model based on the primary key
     */
    protected function loadArticle($article_id)
    {
        //if the article property is null, create it based on input id
        if ($this->_article === null) {
            $this->_article = Article::model()->findByPk($article_id);
            if ($this->_article === null) {
                throw new CHttpException(404, 'the requested article does not exist.');
            }
        }
        return $this->_article;
    }
}
