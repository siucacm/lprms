<?php

/**
 * RegisterForm class.
 * RegisterForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{
	public $first_name;
	public $last_name;
	public $email;
	public $username;
	public $password;
	public $password1;
	public $password2;
	public $phone;
	public $day;
	public $month;
	public $year;
	public $gamertag;
	public $blurb;
	public $img_type;
	public $steam_id;
	public $steam_numeric;
	public $xfire_id;
	public $live_id;
	public $events;

	private $_user;
	private $_activeEvents;

	public function rules()
	{
		$ia = array(
			array('first_name, last_name, email, username, password1, password2', 'required'),
			array('password2', 'compare', 'compareAttribute'=>'password1'),
			array('email', 'emailcheck'), //TODO
			array('username', 'usernamecheck'), //TODO
			array('email', 'email'),
			array('events', 'safe'),
			array('day, month, year, phone', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>24),
			array('email, gamertag, steam_id, steam_numeric, xfire_id, live_id', 'length', 'max'=>64),
		);
		
		if ($this->_activeEvents == NULL) $this->_activeEvents = Event::getActiveEvents();
		
		$ea = array();
		foreach ($this->_activeEvents as $event) {
			array_push($ea, array('events['.$event->id.']', 'safe'));
		}
		return array_merge($ea, $ia);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		$ia = array(
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'username' => 'Username',
			'password1' => 'Password',
			'password2' => 'Password',
			'dummylabel' => 'Confirm Password',
			'phone' => 'Phone',
			'birthday' => 'Birthday',
			'gamertag' => 'Display Name',
		);
		
		if ($this->_activeEvents == NULL) $this->_activeEvents = Event::getActiveEvents();
		
		$ea = array();
		foreach ($this->_activeEvents as $event) {
			$ea['events['.$event->id.']'] = CHtml::link($event->name, $event->url).' ('.date('m/d/Y',strtotime($event->datetime_start)).')';
		}
		return array_merge($ea, $ia);
	}
	
	public function showActiveEvents($form)
	{
		if ($this->_activeEvents == NULL) $this->_activeEvents = Event::getActiveEvents();
		
		foreach ($this->_activeEvents as $event) {
			echo $form->checkBox($this,'events['.$event->id.']');
			echo ' ';
			echo $form->labelEx($this,'events['.$event->id.']');
			echo '<br />';
			echo $form->error($this,'events['.$event->id.']');
		}
	}
	
	public function process()
	{
		if (!Yii::app()->user->isGuest) return false;
		$this->_user = new User;
		if ($this->password1 == $this->password2 && $this->password1 != '')
			$this->_user->password = $this->_user->hashPassword($this->password1);
		else return false;
		$this->_user->birthday = sprintf('%04d', $this->year).'-'.sprintf('%02d',$this->month).'-'.sprintf('%02d',$this->day);
		$this->_user->username = $this->username;
		$this->_user->first_name = $this->first_name;
		$this->_user->last_name = $this->last_name;
		$this->_user->email = $this->email;
		$this->_user->phone = $this->phone;
		$this->_user->gamertag = $this->gamertag;
		$this->_user->register();
		return true;
	}
	
	public function linkEvents()
	{
		$elist = array();
		foreach ($this->events as $key => $value) if ($value == 1) array_push($elist, $key);
		$this->_user->events = $elist;
		$this->_user->save();
	}
	
	public function emailcheck($attribute, $params)
	{
		if (!Yii::app()->user->isGuest) return;
		$this->_user = new User('register');
		$this->_user->email = $this->email;
		if (!$this->_user->validate())
			$this->addError('email','Duplicate e-mail');
	}
	
	public function usernamecheck($attribute, $params)
	{
		if (!Yii::app()->user->isGuest) return;
		$this->_user = new User('register');
		$this->_user->username = $this->username;
		if (!$this->_user->validate())
			$this->addError('username','Duplicate username');
	}
}
