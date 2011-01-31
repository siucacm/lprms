<?php

/**
 * This is the model class for table "web_comments".
 *
 * The followings are the available columns in table 'web_comments':
 * @property string $id
 * @property string $content
 * @property string $author
 * @property string $email
 * @property string $timestamp
 * @property string $id_news
 *
 * The followings are the available model relations:
 * @property WebNews $idNews0
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Comment the static model class
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
		return 'web_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, email, timestamp', 'required'),
			array('author', 'length', 'max'=>32),
			array('email', 'length', 'max'=>64),
			array('id_news', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content, author, email, timestamp, id_news', 'safe', 'on'=>'search'),
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
			'idNews0' => array(self::BELONGS_TO, 'WebNews', 'id_news'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Content',
			'author' => 'Author',
			'email' => 'Email',
			'timestamp' => 'Timestamp',
			'id_news' => 'Id News',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('id_news',$this->id_news,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}