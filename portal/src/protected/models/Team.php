<?php

/**
 * This is the model class for table "event_team".
 *
 * The followings are the available columns in table 'event_team':
 * @property string $id
 * @property string $name
 * @property string $sanitized
 * @property string $id_captain
 * @property integer $size
 *
 * The followings are the available model relations:
 * @property ProfileUser[] $profileUsers
 */
class Team extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Team the static model class
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
		return 'event_team';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sanitized', 'required'),
			array('size', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('sanitized', 'length', 'max'=>32),
			array('id_captain', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, sanitized, id_captain, size', 'safe', 'on'=>'search'),
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
			'profileUsers' => array(self::MANY_MANY, 'ProfileUser', 'ref_user_team(id_team, id_user)'),
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
			'id_captain' => 'Id Captain',
			'size' => 'Size',
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
		$criteria->compare('id_captain',$this->id_captain,true);
		$criteria->compare('size',$this->size);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}