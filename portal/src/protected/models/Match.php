<?php

/**
 * This is the model class for table "game_match".
 *
 * The followings are the available columns in table 'game_match':
 * @property string $id
 * @property string $id_tournament
 * @property integer $tree_position
 * @property integer $team
 * @property string $id_game
 * @property integer $id_platform
 * @property string $id_type
 * @property string $id_winner
 * @property string $host
 * @property string $lobby
 * @property string $datetime_start
 * @property integer $capacity
 * @property string $id_owner
 * @property string $hostname
 * @property string $id_event
 *
 * The followings are the available model relations:
 * @property GamePlatform $idPlatform0
 * @property GameTournament $idTournament0
 * @property GameName $idGame0
 * @property GameType $idType0
 * @property ProfileUser $idWinner0
 * @property ProfileUser $idOwner0
 * @property EventMain $idEvent0
 * @property ProfileUser[] $profileUsers
 */
class Match extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Match the static model class
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
		return 'game_match';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tree_position, team, id_platform, capacity', 'numerical', 'integerOnly'=>true),
			array('id_tournament, id_game, id_type, id_winner, lobby, id_owner', 'length', 'max'=>10),
			array('host', 'length', 'max'=>64),
			array('hostname', 'length', 'max'=>32),
			array('id_event', 'length', 'max'=>11),
			array('datetime_start', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_tournament, tree_position, team, id_game, id_platform, id_type, id_winner, host, lobby, datetime_start, capacity, id_owner, hostname, id_event', 'safe', 'on'=>'search'),
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
			'idPlatform0' => array(self::BELONGS_TO, 'GamePlatform', 'id_platform'),
			'idTournament0' => array(self::BELONGS_TO, 'GameTournament', 'id_tournament'),
			'idGame0' => array(self::BELONGS_TO, 'GameName', 'id_game'),
			'idType0' => array(self::BELONGS_TO, 'GameType', 'id_type'),
			'idWinner0' => array(self::BELONGS_TO, 'ProfileUser', 'id_winner'),
			'idOwner0' => array(self::BELONGS_TO, 'ProfileUser', 'id_owner'),
			'idEvent0' => array(self::BELONGS_TO, 'EventMain', 'id_event'),
			'profileUsers' => array(self::MANY_MANY, 'ProfileUser', 'ref_player_match(id_match, id_player)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_tournament' => 'Id Tournament',
			'tree_position' => 'Tree Position',
			'team' => 'Team',
			'id_game' => 'Id Game',
			'id_platform' => 'Id Platform',
			'id_type' => 'Id Type',
			'id_winner' => 'Id Winner',
			'host' => 'Host',
			'lobby' => 'Lobby',
			'datetime_start' => 'Datetime Start',
			'capacity' => 'Capacity',
			'id_owner' => 'Id Owner',
			'hostname' => 'Hostname',
			'id_event' => 'Id Event',
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
		$criteria->compare('id_tournament',$this->id_tournament,true);
		$criteria->compare('tree_position',$this->tree_position);
		$criteria->compare('team',$this->team);
		$criteria->compare('id_game',$this->id_game,true);
		$criteria->compare('id_platform',$this->id_platform);
		$criteria->compare('id_type',$this->id_type,true);
		$criteria->compare('id_winner',$this->id_winner,true);
		$criteria->compare('host',$this->host,true);
		$criteria->compare('lobby',$this->lobby,true);
		$criteria->compare('datetime_start',$this->datetime_start,true);
		$criteria->compare('capacity',$this->capacity);
		$criteria->compare('id_owner',$this->id_owner,true);
		$criteria->compare('hostname',$this->hostname,true);
		$criteria->compare('id_event',$this->id_event,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}