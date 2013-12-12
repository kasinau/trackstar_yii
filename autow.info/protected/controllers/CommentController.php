<?php

Yii::import('application.vendors.*');
Yii::setPathOfAlias('Zend',Yii::getPathOfAlias('application.vendors.Zend'));

use Zend\Feed\Writer\Feed;
use Zend\View\Model\FeedModel;

class CommentController extends Controller
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
				'actions'=>array('index','view', 'feed'),
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
        if (!Yii::app()->user->checkAccess('createComment')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=new Comment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Comment']))
		{
			$model->attributes=$_POST['Comment'];
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
        if (!Yii::app()->user->checkAccess('updateComment')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Comment']))
		{
			$model->attributes=$_POST['Comment'];
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
        if (!Yii::app()->user->checkAccess('deleteComment')) {
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
		$dataProvider=new CActiveDataProvider('Comment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        if (!Yii::app()->user->checkAccess('updateComment') ||
            !Yii::app()->user->checkAccess('deleteComment')) {
            throw new CHttpException(403, 'You are not authorised to per-form this action.');
        }

        $model=new Comment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Comment']))
			$model->attributes=$_GET['Comment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionFeed()
    {
        $entity = isset($_GET['entity']) ? $_GET['entity'] : null;
        $entity_id = isset($_GET['id']) ? $_GET['id'] : null;

        $comments = Comment::model()->findRecentComments(20, $entity, $entity_id);

        $feed = new Feed();
        $feed->setTitle('Auto-world info Comments Feed');
        $feed->setDescription('Auto-world info Project Comments Feed');
        $feed->setLink($this->createUrl(''));
        $feed->setEncoding('UTF-8');
        foreach ($comments as $comment) {
            $entry = $feed->createEntry();
            $entry->setTitle($comment->article->title);
            $entry->setLink(
                CHtml::encode(
                    $this->createAbsoluteUrl('article/view', array('id' => $comment->article->id))
                )
            );
            $entry->setDescription($comment->user->username . ' says:<br />' . $comment->comment);
            $timestamp_format_time = $comment->create_time ? strtotime($comment->create_time) : 0;
            $entry->setDateModified($timestamp_format_time);
            $entry->addAuthor(
                array(
                    'name' => $comment->user->name ? $comment->user->name : $comment->user->username,
                    'email' => $comment->user->email,
                )
            );
            $feed->addEntry($entry);
        }

//        $feed->export('rss');
//        $feedModel = new FeedModel();
//        $feedModel->setFeed($feed);
//        return $feedModel;

        $out = $feed->export('rss');
        $x = $out;
        echo $out; exit;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Comment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Comment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Comment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
