<?php

/**
 * This is the model class for table "event_prize".
 *
 * The followings are the available columns in table 'event_prize':
 * @property string $id
 * @property string $id_photo
 * @property string $name
 * @property string $count
 * @property string $id_event
 *
 * The followings are the available model relations:
 * @property EventMain $idEvent0
 * @property WebImage $idPhoto0
 */
class Prize extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Prize the static model class
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
		return 'event_prize';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('id_photo, count, id_event', 'length', 'max'=>10),
			array('name', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_photo, name, count, id_event', 'safe', 'on'=>'search'),
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
			'idEvent0' => array(self::BELONGS_TO, 'EventMain', 'id_event'),
			'idPhoto0' => array(self::BELONGS_TO, 'WebImage', 'id_photo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_photo' => 'Id Photo',
			'name' => 'Name',
			'count' => 'Count',
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
		$criteria->compare('id_photo',$this->id_photo,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('count',$this->count,true);
		$criteria->compare('id_event',$this->id_event,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}