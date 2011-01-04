<?php

/**
 * This is the model class for table "web_sponsor".
 *
 * The followings are the available columns in table 'web_sponsor':
 * @property string $id
 * @property string $name
 * @property string $id_photo
 * @property string $website
 *
 * The followings are the available model relations:
 * @property WebImage $idPhoto0
 */
class Sponsor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Sponsor the static model class
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
		return 'web_sponsor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, website', 'required'),
			array('name', 'length', 'max'=>64),
			array('id_photo', 'length', 'max'=>10),
			array('website', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, id_photo, website', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'id_photo' => 'Id Photo',
			'website' => 'Website',
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
		$criteria->compare('id_photo',$this->id_photo,true);
		$criteria->compare('website',$this->website,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}