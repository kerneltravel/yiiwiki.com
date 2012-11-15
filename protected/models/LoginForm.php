<?php

/**
 * 登录类
 * @author Di Zhang <zhangdi5649@126.com>
 * @package application.models
 *
 * @property $username string 用户名
 * @property $password string 密码
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
    public $hashPassword;
	public $rememberMe;

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
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
            array('hashPassword','safe')
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'下次记住我',
            'username'=>'用户名',
            'password'=>'密码',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password,$this->hashPassword);
			if(!$this->_identity->authenticate())
				$this->addError('password','用户名或密码错误.');
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
			$this->_identity=new UserIdentity($this->username,$this->password,$this->hashPassword);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

    /**
     * 使用帐号登录
     * @param string $username 用户名
     * @param string $password 密码,加密后的密码
     * @return boolean 是否登录成功
     */
    public static function loginByAccount($username,$password){
        $model = new self;
        $model->username = $username;
        $model->hashPassword = $password;
        return $model->login();
    }

    public static function loginByWeibo($weiboUid){
        $userOption = UserOption::model()->find('`key`=? and `value`=?',array(UserOption::KEY_WEIBO_SINA_ID,$weiboUid));
        if($userOption === null)
            return false;
        else{
            return self::loginByAccount($userOption->user->username, $userOption->user->passwd);
        }
    }
}
