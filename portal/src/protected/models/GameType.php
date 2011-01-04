<?php

/**
 * This is the model class for table "game_type".
 *
 * The followings are the available columns in table 'game_type':
 * @property string $id
 * @property string $prefix
 * @property string $description
 * @property integer $team
 *
 * The followings are the available model relations:
 * @property GameMatch[] $gameMatches
 * @property GameTournament[] $gameTournaments
 */
class GameType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameType the static model class
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
		return 'game_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('team', 'numerical', 'integerOnly'=>true),
			array('prefix', 'length', 'max'=>2),
			array('description', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, prefix, description, team', 'safe', 'on'=>'search'),
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
			'gameMatches' => array(self::HAS_MANY, 'GameMatch', 'id_type'),
			'gameTournaments' => array(self::HAS_MANY, 'GameTournament', 'id_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'prefix' => 'Prefix',
			'description' => 'Description',
			'team' => 'Team',
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
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('team',$this->team);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}