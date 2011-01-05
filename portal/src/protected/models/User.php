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
 * @property GameMatch[] $gameMatches
 * @property GameTournament[] $gameTournaments
 * @property ProfileSteam $profileSteam
 * @property ProfileRole $idRole0
 * @property ProfileXfire $profileXfire
 * @property RefUserEvent[] $refUserEvents
 * @property EventTeam[] $eventTeams
 * @property WebAlbum[] $webAlbums
 * @property WebNews[] $webNews
 */
class User extends CActiveRecord
{
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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email, username, password, birthday, gamertag, blurb', 'required'),
			array('id_role, active', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>24),
			array('email, gamertag', 'length', 'max'=>64),
			array('username, password, hash', 'length', 'max'=>32),
			array('phone', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name, last_name, email, username, phone, birthday, gamertag, blurb, id_role, datetime_join, active', 'safe', 'on'=>'search'),
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
			'matches' => array(self::MANY_MANY, 'Match', 'ref_player_match(id_player, id_match)'),
			'tournaments' => array(self::HAS_MANY, 'Tournament', 'id_owner'),
			'winner' => array(self::HAS_MANY, 'Tournament', 'id_winner'),
			//'steam' => array(self::HAS_ONE, 'ProfileSteam', 'id'),
			//'xfire' => array(self::HAS_ONE, 'ProfileXfire', 'id'),
			'role' => array(self::BELONGS_TO, 'Role', 'id_role'),
			'events' => array(self::MANY_MANY, 'Event', 'ref_user_event(id_user, id_event)'),
			'teams' => array(self::MANY_MANY, 'Team', 'ref_user_team(id_user, id_team)'),
			'teamCaptain' => array(self::HAS_MANY, 'Team', 'id_captain'),
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
			'gamertag' => 'Gamertag',
			'blurb' => 'Blurb',
			'id_role' => 'Role',
			'datetime_join' => 'Join Date',
			'active' => 'Active',
			'hash' => 'Hash',
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
	
	public function validatePassword($password)
    {
        return $this->hashPassword($password)===$this->password;
    }
 
    public function hashPassword($password)
    {
        return md5($password);
    }
}