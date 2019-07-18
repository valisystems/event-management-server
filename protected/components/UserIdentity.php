<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    protected $_id;
    protected $_roleType;

	public function authenticate()
	{
        $user = User::model()->find('LOWER(login_name)=? OR LOWER(email)=?', array(strtolower($this->username), strtolower($this->username)));
		
        if( $user === null )
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(md5($this->password)!==$user->passwd)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else {
			$this->_id = $user->id_user;
            $this->_roleType = $user->role;
            //print_r($this->_roleType);exit;
            $this->username = trim($user->first_name.' '.$user->last_name);
            $this->errorCode=self::ERROR_NONE;
        }
		return !$this->errorCode;
	}
    
    public function getId(){
        return $this->_id;
    }
}