<?php

/**
 * This is the model class for table "area_location".
 *
 * The followings are the available columns in table 'area_location':
 * @property string $id
 * @property string $name
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property string $floor
 * @property string $room
 *
 * The followings are the available model relations:
 * @property EventMain[] $eventMains
 */
class Location extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Location the static model class
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
		return 'area_location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address1, address2, city, state, country, floor, room', 'required'),
			array('name, address1, address2, city, state, country, floor, room', 'length', 'max'=>32),
			array('zip', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, address1, address2, city, state, zip, country, floor, room', 'safe', 'on'=>'search'),
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
			'event' => array(self::HAS_MANY, 'Event', 'id_location'),
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
			'address1' => 'Address1',
			'address2' => 'Address2',
			'city' => 'City',
			'state' => 'State',
			'zip' => 'Zip',
			'country' => 'Country',
			'floor' => 'Floor',
			'room' => 'Room',
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
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('floor',$this->floor,true);
		$criteria->compare('room',$this->room,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getAddress()
	{
		$result = '';
		$array = array($this->address1, $this->address2, $this->city, $this->state, $this->zip, $this->country);
		foreach ($array as $value)
			if ($value != '') {
				if ($result != '') $result .= '<br />';
				$result .= $value;
			}
		return $result;
	}
	
	public function getLocation()
	{
		$result = '';
		$array = array($this->floor, $this->room);
		foreach ($array as $value)
			if ($value != '') {
				if ($result != '') $result .= ', ';
				$result .= $value;
			}
		return $result;
	}
}