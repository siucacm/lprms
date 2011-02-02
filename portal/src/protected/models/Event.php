<?php

/**
 * This is the model class for table "event_main".
 *
 * The followings are the available columns in table 'event_main':
 * @property string $id
 * @property string $name
 * @property string $sanitized
 * @property string $datetime_start
 * @property string $datetime_end
 * @property string $price
 * @property string $id_location
 * @property string $id_map
 * @property string $capacity
 * @property string $information
 * @property string $reminder
 * @property string $agreement
 * @property integer $min_age
 *
 * The followings are the available model relations:
 * @property AreaMap $idMap
 * @property AreaLocation $idLocation
 * @property EventPrize[] $eventPrizes
 * @property GameMatch[] $gameMatches
 * @property GameTournament[] $gameTournaments
 * @property RefUserEvent[] $refUserEvents
 * @property WebAlbum[] $webAlbums
 */
class Event extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Event the static model class
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
		return 'event_main';
	}
	public function behaviors(){
		return array( 'CAdvancedArBehavior' => array(
			'class' => 'application.extensions.CAdvancedArBehavior'));
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sanitized, datetime_start, datetime_end, information, reminder, agreement', 'required'),
			array('min_age', 'numerical', 'integerOnly'=>true),
			array('name, sanitized', 'length', 'max'=>32),
			array('price', 'length', 'max'=>5),
			array('id_location, id_map, capacity', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, datetime_start, datetime_end, price, id_location, id_map, capacity, information, reminder, agreement, min_age', 'safe', 'on'=>'search'),
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
			'map' => array(self::BELONGS_TO, 'Map', 'id_map'),
			'location' => array(self::BELONGS_TO, 'Location', 'id_location'),
			'prizes' => array(self::HAS_MANY, 'Prize', 'id_event'),
			'matches' => array(self::HAS_MANY, 'Match', 'id_event'),
			'tournaments' => array(self::HAS_MANY, 'Tournament', 'id_event'),
			'users' => array(self::MANY_MANY, 'User', 'ref_user_event(id_event, id_user)'),
			//'webAlbums' => array(self::HAS_MANY, 'WebAlbum', 'id_event'),
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
			'datetime_start' => 'Datetime Start',
			'datetime_end' => 'Datetime End',
			'price' => 'Price',
			'id_location' => 'Location',
			'id_map' => 'Map',
			'capacity' => 'Capacity',
			'information' => 'Information',
			'reminder' => 'Reminder',
			'agreement' => 'Agreement',
			'min_age' => 'Min Age',
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
		$criteria->compare('datetime_start',$this->datetime_start,true);
		$criteria->compare('datetime_end',$this->datetime_end,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('id_location',$this->id_location,true);
		$criteria->compare('id_map',$this->id_map,true);
		$criteria->compare('capacity',$this->capacity,true);
		$criteria->compare('information',$this->information,true);
		$criteria->compare('reminder',$this->reminder,true);
		$criteria->compare('agreement',$this->agreement,true);
		$criteria->compare('min_age',$this->min_age);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getUrl()
    {
        return Yii::app()->createUrl('event/view', array(
            'sanitized'=>$this->sanitized,
        ));
    }
	
	public function getDuration()
	{
		$from = strtotime($this->datetime_start);
		$to = strtotime($this->datetime_end);

		$units = array
			(
				//"week"   => 604800,   // seconds in a week   (7 days)
				//"day"    => 86400,    // seconds in a day    (24 hours)
				"hour"   => 3600,     // seconds in an hour  (60 minutes)
				"minute" => 60,       // seconds in a minute (60 seconds)
				"second" => 1         // 1 second
			);

		$diff = abs($to - $from);
		$output = '';

		foreach($units as $unit => $mult)
			if($diff >= $mult)
			{
				$and = (($mult != 1) ? ("") : ("and "));
				$output .= ", ".$and.intval($diff / $mult)." ".$unit.((intval($diff / $mult) == 1) ? ("") : ("s"));
				$diff -= intval($diff / $mult) * $mult;
			}
		$output = substr($output, strlen(", "));

		return $output;
	}
	
	public function getActive()
	{
		$to = strtotime($this->datetime_end);
		return ($to > time());
	}
	
	public static function getActiveEvents()
	{
		return Event::model()->findAll('datetime_end > NOW()');
	}
	
	public function getStatus()
	{
		if ($this->active != 1) return 'Expired';
		if (Yii::app()->user->isGuest) return '';
		$events = User::getCurrentUser()->events;
		foreach ($events as $event) {
			if ($event->id == $this->id) {
				return $this->linkLeave;
			}
		}
		return $this->linkJoin;
	}
	
	public function getLinkLeave()
	{
		return CHtml::link('Leave', $this->url.'/leave');
	}
	
	public function getLinkJoin()
	{
		return CHtml::link('Join', $this->url.'/join');
	}
	
	public function getDetailedStatus()
	{
		if (Yii::app()->user->isGuest) return '';
		$events = User::getCurrentUser()->events;
		foreach ($events as $event) {
			if ($event->id == $this->id) {
				return 'You are registered for this event.'.(($this->active == 1)?' Changed your mind? '.$this->linkLeave.' now.':'');
			}
		}
		return 'You are not registered for this event.'.(($this->active == 1)?'.. why not '.$this->linkJoin.'?':'');
	}
	
	public static function getDateTime($datetime)
	{
		return date('M j, Y @ g:iA', strtotime($datetime));
	}
	public static function getDate($date)
	{
		return date('M j, Y', strtotime($datetime));
	}
	public static function getTime($time)
	{
		return date('g:iA', strtotime($datetime));
	}
}