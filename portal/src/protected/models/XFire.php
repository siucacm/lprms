<?php

/**
 * This is the model class for table "profile_xfire".
 *
 * The followings are the available columns in table 'profile_xfire':
 * @property string $id
 * @property string $username
 * @property string $display
 * @property string $realname
 * @property integer $online
 * @property string $icon
 * @property integer $valid
 *
 * The followings are the available model relations:
 * @property ProfileUser $id0
 */
class XFire extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return XFire the static model class
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
		return 'profile_xfire';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('online, valid', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('username, display, realname, icon', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, display, realname, online, icon, valid', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'display' => 'Display',
			'realname' => 'Realname',
			'online' => 'Online',
			'icon' => 'Icon',
			'valid' => 'Valid',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('display',$this->display,true);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('online',$this->online);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('valid',$this->valid);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function pullXML() {
		$url = 'http://www.xfire.com/xml/'.$this->username.'/profile/';
		$xr = new XMLReader();
		$xr->open($url);
		$xml = recurseXML($xr);
		$xr->close();
		if (isset($xml['xfire']['error']))
		{
			$this->valid = 0;
			$this->save();
			return;
		}
		$this->username = $xml['xfire']['username'];
		$this->display = $xml['xfire']['nickname'];
		$this->realname = $xml['xfire']['realname'];
		$this->online = ($xml['xfire']['status'] == 'online')?1:0;
		$this->icon = $xml['xfire']['avatar'];
		$this->valid = 1;
		$this->save();
	}
}