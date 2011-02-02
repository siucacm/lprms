<?php

class ForgetForm extends CFormModel
{
	public $email;
	public $username;
	
	public $_user;

	public function rules()
	{
		return array(
			array('email', 'email'),
			array('username, email', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'email' => 'E-mail',
			'username' => 'Username',
		);
	}
	
	public function resetHash()
	{
		if ($this->email != '') {
			$this->_user = User::model()->find('email=:email', array(':email'=>$this->email));
			if ($this->_user == NULL) {
				$this->addError('email','E-mail not found');
				return false;
			}
			$this->_user->hash = User::generateUniqueHash();
			$this->_user->save();
			$this->_user->mailReset();
			return true;
		}
		if ($this->username != '') {
			$this->_user = User::model()->find('username=:username', array(':username'=>$this->username));
			if ($this->_user == NULL) {
				$this->addError('username','Username not found');
				return false;
			}
			$this->_user->hash = User::generateUniqueHash();
			$this->_user->save();
			$this->_user->mailReset();
			return true;
		}
		$this->addError('email','E-mail not found');
		return false;
	}
}
