<?php

class EventController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('join','leave'),
				'users'=>array('@'),
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
	
	public function actionView()
	{
		$model=$this->loadModel();
		if($model===null) throw new CHttpException(404,'The requested page does not exist.');
		else
			$this->render('view',array(
				'model'=>$model,
			));
	}
	 
	 /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel()
	{
		$model = null;
		if(isset($_GET['id']))
		{
			$model=Event::model()->findByPk($_GET['id']);
		}
		else if(isset($_GET['sanitized']))
		{
			$model=Event::model()->find('sanitized=:sanitized', array(':sanitized'=>$_GET['sanitized']));
		}
		return $model;
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria1=new CDbCriteria(array(
			'order'=>'datetime_start ASC',
			'condition'=>'datetime_end > NOW()',
		));
		$dataProvider1=new CActiveDataProvider('Event', array('criteria'=>$criteria1));
		$criteria2=new CDbCriteria(array(
			'order'=>'datetime_start DESC',
			'condition'=>'datetime_end < NOW()',
		));
		$dataProvider2=new CActiveDataProvider('Event', array('criteria'=>$criteria2));
		$this->render('index',array(
			'dataProvider1'=>$dataProvider1,
			'dataProvider2'=>$dataProvider2,
		));
	}
	
	public function actionJoin()
	{
		if (Yii::app()->user->isGuest)$this->redirect('/event/index');
		$model = $this->loadModel();
		$user = User::getCurrentUser();
		if ($model !== null) $user->joinEvent($model->id);
		$this->redirect('/event/index');
	}
	
	public function actionLeave()
	{
		if (Yii::app()->user->isGuest)$this->redirect('/event/index');
		$model = $this->loadModel();
		$user = User::getCurrentUser();
		if ($model !== null) $user->leaveEvent($model->id);
		$this->redirect('/event/index');
	}
}
