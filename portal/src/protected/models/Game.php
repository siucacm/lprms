<?php

/**
 * This is the model class for table "game_name".
 *
 * The followings are the available columns in table 'game_name':
 * @property string $id
 * @property string $name
 * @property string $image
 * @property string $id_steam
 * @property string $id_xfire
 *
 * The followings are the available model relations:
 * @property GameMatch[] $gameMatches
 * @property GameTournament[] $gameTournaments
 */
class Game extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Game the static model class
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
		return 'game_name';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, image, id_xfire', 'required'),
			array('name, id_xfire', 'length', 'max'=>32),
			array('image', 'length', 'max'=>128),
			array('id_steam', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, image, id_steam, id_xfire', 'safe', 'on'=>'search'),
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
			'gameMatches' => array(self::HAS_MANY, 'GameMatch', 'id_game'),
			'gameTournaments' => array(self::HAS_MANY, 'GameTournament', 'id_game'),
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
			'image' => 'Image',
			'id_steam' => 'Id Steam',
			'id_xfire' => 'Id Xfire',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('id_steam',$this->id_steam,true);
		$criteria->compare('id_xfire',$this->id_xfire,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}