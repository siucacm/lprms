<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class HashIdentity extends CUserIdentity
{
	
	private $_id;
	public $hash;
 
    public function authenticate()
    {
        $user=User::model()->find('LOWER(hash)=?',array($this->hash));
        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else
        {
            $this->_id=$user->id;
            $this->username=$user->username;
            $this->errorCode=self::ERROR_NONE;
        }
        return $this->errorCode==self::ERROR_NONE;
    }
 
    public function getID()
    {
        return $this->_id;
    }
}