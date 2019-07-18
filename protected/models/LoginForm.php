<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $extension;
	public $password;
	public $rememberMe;
	public $loginMode;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required', 'on' => 'login, loginStaff'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
			array('loginMode', 'safe'),
			array('extension','numerical'),
			array('extension','required', 'on' => 'loginStaff'),
			array('username, password, extension', 'safe', 'on' => 'loginStaff'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{


		return array(
			'rememberMe'=>'Remember me next time',
			'extension'=> 'Extension Number',
			'username'=> ($this->scenario =='login' ? 'User Name' : 'Personal ID'),
			'password' => ($this->scenario =='login' ? 'Password' : 'PIN Code')
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors() && $this->getScenario() =='login')
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
        if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*1 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			//Yii::app()->redirect('/site/contact');
            return true;
		}
		else
			return false;
	}
}
