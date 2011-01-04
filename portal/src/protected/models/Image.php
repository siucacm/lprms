<?php

/**
 * This is the model class for table "web_image".
 *
 * The followings are the available columns in table 'web_image':
 * @property string $id
 * @property string $id_album
 * @property string $file
 * @property string $title
 *
 * The followings are the available model relations:
 * @property EventPrize[] $eventPrizes
 * @property WebAlbum $idAlbum0
 * @property WebSponsor[] $webSponsors
 */
class Image extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Image the static model class
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
		return 'web_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file', 'required'),
			array('id_album', 'length', 'max'=>10),
			array('file', 'length', 'max'=>128),
			array('title', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_album, file, title', 'safe', 'on'=>'search'),
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
			'eventPrizes' => array(self::HAS_MANY, 'EventPrize', 'id_photo'),
			'idAlbum0' => array(self::BELONGS_TO, 'WebAlbum', 'id_album'),
			'webSponsors' => array(self::HAS_MANY, 'WebSponsor', 'id_photo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_album' => 'Id Album',
			'file' => 'File',
			'title' => 'Title',
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
		$criteria->compare('id_album',$this->id_album,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}