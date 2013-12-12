<?php

class ArticleController extends Controller
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
            'carGenerationContext + create index admin', //check to ensure valid car generation context
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
        $article = $this->loadModel($id, true);
        $comment = $this->createComment($article);

        $photoDataProvider = new CActiveDataProvider(
            'Photo',
            array(
                'criteria' => array(
                    'condition' => 'article_id=:articleId',
                    'params' => array(':articleId' => $id),
                ),
                'pagination' => array(
                    'pageSize' => 1,
                ),
            )
        );
		$this->render('view',array(
			'model'=> $article,
			'photoDataProvider'=>$photoDataProvider,
            'comment' => $comment,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        if (!Yii::app()->user->checkAccess('createArticle')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=new Article;
        $model->car_generation_id = $this->_car_generation->id;
        $model->user_id = 1;
//        $model->user_id = $_SESSION["user_id"];

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
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
        if (!Yii::app()->user->checkAccess('updateArticle')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
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
        if (!Yii::app()->user->checkAccess('deleteArticle')) {
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
            'Article',
            array(
                'criteria' => array(
                    'condition' => 'car_generation_id=:carGenerationId',
                    'params' => array(':carGenerationId' =>$this->_car_generation->id),
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
        if (!Yii::app()->user->checkAccess('updateArticle') ||
            !Yii::app()->user->checkAccess('deleteArticle')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=new Article('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Article']))
			$model->attributes=$_GET['Article'];

        $model->car_generation_id = $this->_car_generation->id;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Article the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id, $withComments = false)
	{
        if ($withComments) {
            $model = Article::model()->with(
                array(
                    'comments' => array(
                        'with' => 'user'
                    ),
                )
            )->findAllByPk($id);
            if (is_array($model) && isset($model[0])) {
                $model = $model[0];
            }
        } else {
            $model = Article::model()->findByPk($id);
        }

        if ($model === null) {
            throw new CHttpException(404, 'The request page does not exist.');
        }

        return $model;

//		$model=Article::model()->findByPk($id);
//		if($model===null)
//			throw new CHttpException(404,'The requested page does not exist.');
//		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Article $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-form')
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
    public function filterCarGenerationContext($filterChain)
    {
        //set the car generation identifier based on either the get or post input
        //request variables, since we allow both types for our actions
        $car_generation_id = isset($_GET['car_generation_id']) ?
            $_GET['car_generation_id'] : (isset($_POST['car_generation_id']) ? $_POST['car_generation_id'] : null);
        $this->loadCargeneration($car_generation_id);
        //complete the running of other filters and execute the requested action
        $filterChain->run();
    }

    /**
     * @var private property containing the associated CarGeneration model instance
     */
    private $_car_generation = null;

    /**
     * Protected method to load the associated CarGeneration model class
     * @car_generation_id the primary identifier of the associated CarGeneration
     * @return object the CarGeneration data model based on the primary key
     */
    protected function loadCarGeneration($car_generation_id)
    {
        //if the car_generation property is null, create it based on input id
        if ($this->_car_generation === null) {
            $this->_car_generation = CarGeneration::model()->findByPk($car_generation_id);
            if ($this->_car_generation === null) {
                throw new CHttpException(404, 'the requested car generation does not exist.');
            }
        }
        return $this->_car_generation;
    }

    /**
     * @param $article
     * @return Comment
     */
    protected function createComment($article)
    {
        $comment = new Comment();
        if (isset($_POST['Comment'])) {
            $comment->attributes = $_POST['Comment'];
            if ($article->addComment($comment)) {
                Yii::app()->user->setFlash('commentSubmitted', 'Your comment has been added.');
                $this->refresh();
            }
        }
        return $comment;
    }
}
