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
		if (!Yii::app()->user->isGuest) {
			$this->redirect('/account');
		}
		$model=new RegisterForm;

		// uncomment the following code to enable ajax-based validation
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-register-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['RegisterForm']))
		{
			$model->attributes=$_POST['RegisterForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->process())
			{
				$model->linkEvents();
				$this->redirect('/account/confirm');
			}
		}
		$this->render('register',array(
			'model'=>$model,
		));
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
				$this->redirect('/account');
		}
		$model->populate();
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
		else if(isset($_GET['extra']))
		{
			$model->confirm=$_GET['extra'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				$user = $model=User::model()->find('id=:id', array(':id'=>Yii::app()->user->id));
				$user->confirm();
				$this->redirect('/account/dashboard/active');
			}
			else
				$this->redirect('/account/login/confirmed');
		}
		// display the confirm form
		else $this->render('confirm',array('model'=>$model));
	}

	public function actionForget()
	{
		$model=new ForgetForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-forget-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['ForgetForm']))
		{
			$model->attributes=$_POST['ForgetForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->resetHash())
				$this->redirect('/account/reset');
		}
		// display the confirm form
		$this->render('forget',array('model'=>$model));
	}
	
	public function actionReset()
	{
		$model=new ResetForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-reset-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['ResetForm']))
		{
			$model->attributes=$_POST['ResetForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				$user = User::model()->find('id=:id', array(':id'=>Yii::app()->user->id));
				$user->reset($model->password1);
				$this->redirect('/account/dashboard/active');
			}
		}
		else if(isset($_GET['extra'])) $model->reset=$_GET['extra'];
		$this->render('reset',array('model'=>$model));
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
