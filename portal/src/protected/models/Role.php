<?php

/**
 * This is the model class for table "profile_role".
 *
 * The followings are the available columns in table 'profile_role':
 * @property integer $id
 * @property string $name
 * @property integer $is_active
 * @property integer $is_admin
 * @property integer $is_mod
 * @property integer $is_poster
 * @property integer $is_media
 * @property integer $is_events
 *
 * The followings are the available model relations:
 * @property ProfileUser[] $profileUsers
 */
class Role extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Role the static model class
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
		return 'profile_role';
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
			array('is_active, is_admin, is_mod, is_poster, is_media, is_events', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, is_active, is_admin, is_mod, is_poster, is_media, is_events', 'safe', 'on'=>'search'),
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
			'profileUsers' => array(self::HAS_MANY, 'ProfileUser', 'id_role'),
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
			'is_active' => 'Is Active',
			'is_admin' => 'Is Admin',
			'is_mod' => 'Is Mod',
			'is_poster' => 'Is Poster',
			'is_media' => 'Is Media',
			'is_events' => 'Is Events',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_admin',$this->is_admin);
		$criteria->compare('is_mod',$this->is_mod);
		$criteria->compare('is_poster',$this->is_poster);
		$criteria->compare('is_media',$this->is_media);
		$criteria->compare('is_events',$this->is_events);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}