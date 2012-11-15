<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    public $hashPassword;
    private $_id;

    public function  __construct($username, $password,$hasPassword) {
        $this->username = $username;
        $this->password = $password;
        $this->hashPassword = $hasPassword;
    }
    
    public function authenticate() {
        $user = User::model()->find('LOWER(username)=?', array(strtolower($this->username)));
        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ( empty($this->hashPassword)?(!$user->validatePassword($this->password)):$user->passwd != $this->hashPassword){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }else {
            $this->_id = $user->id;
            $this->username = $user->nickname;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

}