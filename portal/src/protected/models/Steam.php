<?php

/**
 * This is the model class for table "profile_steam".
 *
 * The followings are the available columns in table 'profile_steam':
 * @property string $id_username
 * @property string $id_numeric
 * @property string $id
 * @property string $display
 * @property string $realname
 * @property integer $online
 * @property string $state
 * @property string $iconFull
 * @property string $iconMedium
 * @property string $icon
 * @property string $headline
 * @property string $summary
 * @property double $rating
 * @property integer $valid
 *
 * The followings are the available model relations:
 * @property ProfileUser $user
 */
class Steam extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Steam the static model class
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
		return 'profile_steam';
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
			array('rating', 'numerical'),
			array('id_username, display, realname', 'length', 'max'=>64),
			array('id_numeric', 'length', 'max'=>20),
			array('id', 'length', 'max'=>10),
			array('state', 'length', 'max'=>32),
			array('iconFull, iconMedium, icon, headline, summary', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_username, id_numeric, id, display, realname, online, state, iconFull, iconMedium, icon, headline, summary, rating, valid', 'safe', 'on'=>'search'),
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
			'id_username' => 'Id Username',
			'id_numeric' => 'Id Numeric',
			'id' => 'ID',
			'display' => 'Display',
			'realname' => 'Realname',
			'online' => 'Online',
			'state' => 'State',
			'iconFull' => 'Icon Full',
			'iconMedium' => 'Icon Medium',
			'icon' => 'Icon',
			'headline' => 'Headline',
			'summary' => 'Summary',
			'rating' => 'Rating',
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

		$criteria->compare('id_username',$this->id_username,true);
		$criteria->compare('id_numeric',$this->id_numeric,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('display',$this->display,true);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('online',$this->online);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('iconFull',$this->iconFull,true);
		$criteria->compare('iconMedium',$this->iconMedium,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('headline',$this->headline,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('valid',$this->valid);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getUrl() {
		if ($this->id_username != null) return 'http://steamcommunity.com/id/'.$this->id_username;
		if ($this->id_numeric != null) return 'http://steamcommunity.com/profiles'.$this->id_numeric;
		return '';
	}
	
	public function getLink() {
		if ($this->url != '') return '<a href="'.$this->url.'" title="'.$this->display.'">'.$this->display.'</a>';
		return '';
	}
}