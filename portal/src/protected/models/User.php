<?php

/**
 * This is the model class for table "profile_user".
 *
 * The followings are the available columns in table 'profile_user':
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $phone
 * @property string $birthday
 * @property string $gamertag
 * @property string $blurb
 * @property integer $id_role
 * @property string $datetime_join
 * @property integer $active
 * @property string $hash
 *
 * The followings are the available model relations:
 * @property Match[] $matches
 * @property Tournament[] $tournaments
 * @property Steam $steam
 * @property Role $role
 * @property Xfire $xfire
 * @property Event[] $events
 * @property Team[] $teams
 * @property WebAlbum[] $webAlbums
 * @property WebNews[] $webNews
 */
class User extends CActiveRecord
{
	private $_day = NULL;
	private $_month = NULL;
	private $_year = NULL;
	
	const IMG_GRAVATAR = 0;
	const IMG_CUSTOM = 1;
	const IMG_STEAM = 2;
	const IMG_XFIRE = 3;
	const IMG_LIVE = 4;

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile_user';
	}
	
	public function behaviors(){
		return array( 'CAdvancedArBehavior' => array(
			'class' => 'application.extensions.CAdvancedArBehavior'));
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('first_name, last_name, email, username', 'required'),
			array('email', 'email'),
			array('username, email', 'unique', 'on' => 'register'),
			array('hash', 'unique', 'on' => 'postregister'),
			array('email', 'unique', 'on' => 'edit'),
			array('day, month, year, img_type', 'numerical'),
			array('first_name, last_name', 'length', 'max'=>24),
			array('email, gamertag', 'length', 'max'=>64),
			array('username, hash', 'length', 'max'=>32),
			array('phone', 'length', 'max'=>20),
			array('blurb', 'length', 'max'=>2048),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name, last_name, email, username, gamertag', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'matches' => array(self::MANY_MANY, 'Match', 'ref_player_match(id_player, id_match)'),
			//'tournaments' => array(self::HAS_MANY, 'Tournament', 'id_owner'),
			//'winner' => array(self::HAS_MANY, 'Tournament', 'id_winner'),
			'steam' => array(self::HAS_ONE, 'Steam', 'id'),
			'xfire' => array(self::HAS_ONE, 'XFire', 'id'),
			'role' => array(self::BELONGS_TO, 'Role', 'id_role'),
			'events' => array(self::MANY_MANY, 'Event', 'ref_user_event(id_user, id_event)'),
			//'teams' => array(self::MANY_MANY, 'Team', 'ref_user_team(id_user, id_team)'),
			//'teamCaptain' => array(self::HAS_MANY, 'Team', 'id_captain'),
			//'webAlbums' => array(self::HAS_MANY, 'WebAlbum', 'id_user'),
			//'webNews' => array(self::HAS_MANY, 'WebNews', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'username' => 'Username',
			'password' => 'Password',
			'phone' => 'Phone',
			'birthday' => 'Birthday',
			'gamertag' => 'Display Name',
			'blurb' => 'Blurb',
			'id_role' => 'Role',
			'datetime_join' => 'Join Date',
			'active' => 'Active',
			'hash' => 'Confirmation Code',
			'img_type' => 'Avatar Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('gamertag',$this->gamertag,true);
		$criteria->compare('blurb',$this->blurb,true);
		$criteria->compare('id_role',$this->id_role);
		$criteria->compare('datetime_join',$this->datetime_join,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function register()
	{
		$this->hash = User::generateUniqueHash();
		$this->datetime_join = date('Y-m-d');
		if ($this->save()) $this->mailRegistration();
	}
	
	public function confirm()
	{
		$this->active = 1;
		if ($this->steam == NULL) {
			$steam = new Steam;
			$steam->id = $this->id;
			$steam->save();
		}
		if ($this->xfire == NULL) {
			$xfire = new XFire;
			$xfire->id = $this->id;
			$xfire->save();
		}
		$this->hash = NULL;
		$this->save();
	}
	
	public function reset($password)
	{
		$this->hash = NULL;
		$this->password = $this->hashPassword($password);
		$this->save();
	}
	
	public function validatePassword($password)
    {
        return $this->hashPassword($password)===$this->password;
    }
 
    public function hashPassword($password)
    {
        return md5($password);
    }
	
	public function getUrl()
	{
		return Yii::app()->createUrl('user/view', array(
            'username'=>$this->username,
        ));
	}
	
	public function getImg($size = 100)
	{
		return '<img src="'.$this->avatar.'" width="'.$size.'" height="'.$size.'" title="'.$this->username.'"/>';
	}
	
	public function __get($value) {
		switch ($value) {
			case 'day': 
				if ($this->_day === NULL)
					$this->_day = (date('d',strtotime($this->birthday))+0);
				return $this->_day;
			case 'month':
				if ($this->_month=== NULL)
					$this->_month = (date('m',strtotime($this->birthday))+0);
				return $this->_month;
			case 'year':
				if ($this->_year === NULL)
					$this->_year = (date('Y',strtotime($this->birthday))+0);
				return $this->_year;
			default: return parent::__get($value);
		}
	}
	
	public function __set($name, $value) {
		switch ($name) {
			case 'day': $this->_day = $value;
				$birthday = date('Y-m-',strtotime($this->birthday)).sprintf('%02d',$value);
				break;
			case 'month': $this->_month = $value;
				$birthday = date('Y-',strtotime($this->birthday)).sprintf('%02d',$value).date('-d',strtotime($this->birthday));
				break;
			case 'year': $this->_year = $value;
				$birthday = sprintf('%02d',$value).date('-m-d',strtotime($this->birthday));
				break;
			default: parent::__set($name, $value);
		}
	}
	
	public function getSteamAvatar() {
		if ($this->steam != null && $this->steam->valid) return $this->steam->iconFull;
		return $this->unknown;
	}
	
	public function getXfireAvatar() {
		if ($this->xfire != null && $this->xfire->valid) return $this->xfire->icon;
		return $this->unknown;
	}
	
	public function getGravatar() {
		return 'http://www.gravatar.com/avatar/'.md5($this->email).'.jpg?d=retro&s=100';
	}
	
	public function getUnknown() {
		return 'http://www.gravatar.com/avatar/'.md5($this->email).'.jpg?d=retro&s=100&f=y';
	}
	
	public static function dayList() {
		$array = array();
		for ($i = 1; $i <= 31; $i++) {
			$array["$i"] = $i;
		}
		return $array;
	}
	
	public static function monthList() {
		$array = array();
		for ($i = 1; $i <= 12; $i++) {
			$date = new DateTime('2000-'.sprintf('%02d',$i).'-01');
			$array["$i"] = date_format($date, 'F');
		}
		return $array;
	}
	
	public static function yearList() {
		$array = array();
		for ($i = date('Y'); $i >= 1950; $i--) {
			$array["$i"] = $i;
		}
		return $array;
	}
	
	public static function imgTypeList() {
		return array(User::IMG_GRAVATAR => 'Gravatar',
			User::IMG_CUSTOM => 'Custom',
			User::IMG_STEAM => 'Steam',
			User::IMG_XFIRE => 'XFire',
			User::IMG_LIVE => 'Live',
		);
	}
	
	public static function generateUniqueHash() {
		$result = false;
		$hash = '';
		while (!$result) {
			$hash = md5(rand());
			$user = new User('postregister');
			$user->hash = $hash;
			$result = $user->validate();
		}
		return $hash;
	}
	
	public function getLiveCard()
	{
		//if (
	}
	
	public function getAvatar()
	{
		switch ($this->img_type)
		{
			case User::IMG_GRAVATAR: return $this->gravatar;
			case User::IMG_STEAM: return $this->steamAvatar;
			case User::IMG_XFIRE: return $this->xfireAvatar;
			case User::IMG_LIVE:
			default: return $this->unknown;
		}
	}
	
	public function mailRegistration()
	{
		mail(
			$this->email,
			'Registration details to '.Yii::app()->name,
'Dear '.$this->username.',

Thank you for your interest in '.Yii::app()->name.'! Your credentials are as follows:
Username: '.$this->username.'
E-mail: '.$this->email.'
Password: <not disclosed>

You may click on the following link (http://'.$_SERVER['SERVER_NAME'].Yii::app()->request->getBaseUrl().'/account/confirm/'.$this->hash.') to activate your account, or enter the code ('.$this->hash.') at http://'.$_SERVER['SERVER_NAME'].Yii::app()->request->getBaseUrl().'/account/confirm . From there, you can then register for events and tournaments.

If this is not you, feel free to disregard this e-mail.

Sincerely,
SalukiLAN Team
',
			'From: '.Yii::app()->params['adminEmail']
		);
	}
	
	public function mailReset()
	{
		mail(
			$this->email,
			'Password Reset details to '.Yii::app()->name,
'Dear '.$this->username.',

Someone has request a password reset for your account:
Username: '.$this->username.'
E-mail: '.$this->email.'

You may click on the following link (http://'.$_SERVER['SERVER_NAME'].Yii::app()->request->getBaseUrl().'/account/reset/'.$this->hash.') to reset your password, or enter the code ('.$this->hash.') at http://'.$_SERVER['SERVER_NAME'].Yii::app()->request->getBaseUrl().'/account/reset . From there, you can then log back into your account.

If this is not you, feel free to disregard this e-mail.

Sincerely,
SalukiLAN Team
',
			'From: '.Yii::app()->params['adminEmail']
		);
	}
	
	public static function getCurrentUser()
	{
		if (Yii::app()->user->isGuest) return NULL;
		return User::model()->find('id=:id', array(':id'=>Yii::app()->user->id));
	}
	
	public function joinEvent($eid)
	{
		if (Yii::app()->user->isGuest) return false;
		$user = User::getCurrentUser();
		$eventArray = array($eid);
		foreach ($user->events as $event) {
			if ($event->id != $eid)
				array_push($eventArray, $event->id);
		}
		$user->events = array();
		$user->save();
		$user->events = $eventArray;
		$user->save();
		return true;
	}
	
	public function leaveEvent($eid)
	{
		if (Yii::app()->user->isGuest) return false;
		$user = User::getCurrentUser();
		$eventArray = array();
		foreach ($user->events as $event) {
			if ($event->id != $eid)
				array_push($eventArray, $event->id);
		}
		$user->events = array();
		$user->save();
		$user->events = $eventArray;
		$user->save();
		return true;
	}
}