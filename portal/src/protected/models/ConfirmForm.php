<?php

/**
 * ConfirmForm class.
 * ConfirmForm is the data structure for keeping
 * user confirm form data. It is used by the 'confirm' action of 'SiteController'.
 */
class ConfirmForm extends CFormModel
{
	public $confirm;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// confirmation code is required
			array('confirm', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array();
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new HashIdentity(NULL, NULL);
			$this->_identity->hash = $this->confirm;
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===HashIdentity::ERROR_NONE)
		{
			Yii::app()->user->login($this->_identity,0);
			return true;
		}
		else
			return false;
	}
}
