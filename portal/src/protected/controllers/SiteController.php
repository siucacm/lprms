<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria(array(
			'order'=>'timestamp DESC',
		));
		$posts = Post::model()->findAll($criteria);
		$ecriteria=new CDbCriteria(array(
			'order'=>'datetime_start DESC',
			'condition'=>'datetime_start < NOW()',
		));
		$events = Event::model()->findAll($ecriteria);
		$ucriteria=new CDbCriteria(array(
			'order'=>'datetime_join DESC',
			'condition'=>'active = 1',
		));
		$users = User::model()->findAll($ucriteria);
		$this->render('index', array(
			'post' => $posts[0],
			'events' => $events,
			'users' => $users,
			));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!Yii::app()->user->isGuest)
		{
			$this->redirect('/account');
		}
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				//$this->redirect(Yii::app()->user->returnUrl);
				$this->redirect('/account');
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	public function actionRegister()
	{
		$model=new User('register');

		// uncomment the following code to enable ajax-based validation
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-register-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->validate())
			{
				$model->register();
				$this->redirect('/confirm');
			}
		}
		$this->render('register',array('model'=>$model));
	}
	
	public function actionDashboard()
	{
		if (Yii::app()->user->isGuest) {
			$this->redirect('/account/login');
		}
		$model=new DashboardForm;
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-dashboard')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['DashboardForm']))
		{
			$model->attributes=$_POST['DashboardForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->process())
				$this->redirect('/account/dashboard');
		}
		else $model->populate();
		$this->render('dashboard',array(
			'model'=>$model,
		));
	}
	
	public function actionConfirm()
	{
		$model=new ConfirmForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-confirm-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['ConfirmForm']))
		{
			$model->attributes=$_POST['ConfirmForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				$user = $model=User::model()->find('id=:id', array(':id'=>Yii::app()->user->id));
				$user->confirm();
				$this->redirect('/account/dashboard/active');
			}
		}
		if(isset($_GET['extra']))
		{
			$model->confirm=$_GET['extra'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				$user = $model=User::model()->find('id=:id', array(':id'=>Yii::app()->user->id));
				$user->confirm();
				$this->redirect('/account/dashboard/active');
			}
		}
		// display the confirm form
		$this->render('confirm',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}