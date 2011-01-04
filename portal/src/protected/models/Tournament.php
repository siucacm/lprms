<?php

/**
 * This is the model class for table "game_tournament".
 *
 * The followings are the available columns in table 'game_tournament':
 * @property string $id
 * @property string $name
 * @property string $sanitized
 * @property integer $rounds
 * @property string $id_game
 * @property string $id_type
 * @property integer $team
 * @property string $id_owner
 * @property string $id_event
 * @property integer $started
 *
 * The followings are the available model relations:
 * @property GameMatch[] $gameMatches
 * @property EventMain $idEvent0
 * @property GameName $idGame0
 * @property GameType $idType0
 * @property ProfileUser $idOwner0
 */
class Tournament extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tournament the static model class
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
		return 'game_tournament';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rounds, team, started', 'numerical', 'integerOnly'=>true),
			array('name, sanitized', 'length', 'max'=>32),
			array('id_game, id_type, id_owner, id_event', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, sanitized, rounds, id_game, id_type, team, id_owner, id_event, started', 'safe', 'on'=>'search'),
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
			'gameMatches' => array(self::HAS_MANY, 'GameMatch', 'id_tournament'),
			'idEvent0' => array(self::BELONGS_TO, 'EventMain', 'id_event'),
			'idGame0' => array(self::BELONGS_TO, 'GameName', 'id_game'),
			'idType0' => array(self::BELONGS_TO, 'GameType', 'id_type'),
			'idOwner0' => array(self::BELONGS_TO, 'ProfileUser', 'id_owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'sanitized' => 'Sanitized',
			'rounds' => 'Rounds',
			'id_game' => 'Id Game',
			'id_type' => 'Id Type',
			'team' => 'Team',
			'id_owner' => 'Id Owner',
			'id_event' => 'Id Event',
			'started' => 'Started',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sanitized',$this->sanitized,true);
		$criteria->compare('rounds',$this->rounds);
		$criteria->compare('id_game',$this->id_game,true);
		$criteria->compare('id_type',$this->id_type,true);
		$criteria->compare('team',$this->team);
		$criteria->compare('id_owner',$this->id_owner,true);
		$criteria->compare('id_event',$this->id_event,true);
		$criteria->compare('started',$this->started);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}