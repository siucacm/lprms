<?php

class ResetForm extends CFormModel
{
	public $reset;
	public $password1;
	public $password2;

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
			array('reset, password1, password2', 'required'),
			array('password2', 'compare', 'compareAttribute'=>'password1'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'reset' => 'Reset Code',
			'password1' => 'Password',
			'password2' => 'Confirm Password',
		);
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
			$this->_identity->hash = $this->reset;
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
