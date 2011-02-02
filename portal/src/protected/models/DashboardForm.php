<?php

class DashboardForm extends CFormModel
{
	public $first_name;
	public $last_name;
	public $email;
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

	private $_user;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('first_name, last_name, email', 'required'),
			array('password1', 'compare', 'compareAttribute'=>'password2'),
			array('password2', 'compare', 'compareAttribute'=>'password1'),
			array('email', 'email'),
			array('email', 'emailcheck'), //TODO
			array('day, month, year, img_type, phone, steam_numeric', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>24),
			array('email, gamertag, steam_id, steam_numeric, xfire_id, live_id', 'length', 'max'=>64),
			array('blurb', 'length', 'max'=>2048),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'password1' => 'Password',
			'password2' => 'Confirm Password',
			'phone' => 'Phone',
			'birthday' => 'Birthday',
			'gamertag' => 'Display Name',
			'blurb' => 'Blurb',
			'img_type' => 'Avatar Image Type',
			'steam_id' => 'Steam ID',
			'steam_numeric' => 'Steam Numeric ID',
			'xfire_id' => 'XFire ID',
			'live_id' => 'Live ID',
		);
	}
	
	public function populate()
	{
		if (Yii::app()->user->isGuest) return;
		$this->_user = User::getCurrentUser();
		//print_r(Yii::app()->user); exit;
		if ($this->_user == NULL) return;
		$this->first_name = $this->_user->first_name;
		$this->last_name = $this->_user->last_name;
		$this->email = $this->_user->email;
		$this->phone = $this->_user->phone;
		$time = strtotime($this->_user->birthday);
		$this->day = date('d', $time);
		$this->month = date('m', $time);
		$this->year = date('Y', $time);
		$this->gamertag = $this->_user->gamertag;
		$this->blurb = $this->_user->blurb;
		$this->img_type = $this->_user->img_type;
		$this->steam_id = $this->_user->steam->id_username;
		$this->steam_numeric = $this->_user->steam->id_numeric;
		$this->xfire_id = $this->_user->xfire->username;
	}
	
	public function process()
	{
		if (Yii::app()->user->isGuest) return;
		$this->_user = User::getCurrentUser();
		if ($this->_user == NULL) return;
		if ($this->password1 == $this->password2 && $this->password1 != '')
			$this->_user->password = $this->_user->hashPassword($this->password1);
		$this->_user->birthday = sprintf('%04d', $this->year).'-'.sprintf('%02d',$this->month).'-'.sprintf('%02d',$this->day);
		$this->_user->first_name = $this->first_name;
		$this->_user->last_name = $this->last_name;
		$this->_user->email = $this->email;
		$this->_user->phone = $this->phone;
		$this->_user->gamertag = $this->gamertag;
		$this->_user->blurb = $this->blurb;
		$this->_user->img_type = $this->img_type;
		$this->_user->steam->id_username = $this->steam_id;
		$this->_user->steam->id_numeric = $this->steam_numeric;
		$this->_user->steam->pullXML();
		$this->_user->xfire->username = $this->xfire_id;
		$this->_user->xfire->pullXML();
		$this->_user->save();
	}
	
	public function pullUser()
	{
		return $this->_user;
	}
	
	public function emailcheck($attribute, $params)
	{
		if (Yii::app()->user->isGuest) return;
		$this->_user = User::getCurrentUser();
		if ($this->_user->email == $this->email) return;
		$this->_user = new User('register');
		$this->_user->email = $this->email;
		if (!$this->_user->validate())
			$this->addError('email','Duplicate email');
	}
}
