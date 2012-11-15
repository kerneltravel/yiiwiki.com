<?php

/**
 * 描述 Weibo
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */

class YWeibo extends CApplicationComponent{

    const TOKEN = 'token';
    const AUTH_TYPE = 'code';

    const CATEGORY_SINA = 1;
    const CATEGORY_QQ = 2;

    public $category = 1;
    public $akey;
    public $skey;
    public $callbackUrl;
    
    public $debug = false;

    private $_keyPrefix = 'weibo_';

    private $_auth;
    private $_client;
    private $_returnUrl;


    public function __get($name)
	{
		if($this->hasState($name))
			return $this->getState($name);
		else
			return parent::__get($name);
	}

	public function __set($name,$value)
	{
		if($this->hasState($name))
			$this->setState($name,$value);
		else
			parent::__set($name,$value);
	}

	public function __isset($name)
	{
		if($this->hasState($name))
			return $this->getState($name)!==null;
		else
			return parent::__isset($name);
	}

	public function __unset($name)
	{
		if($this->hasState($name))
			$this->setState($name,null);
		else
			parent::__unset($name);
	}

    public function  __call($name, $parameters) {
        if(method_exists($this->getAuth(), $name)){
            return call_user_method ($name, $this->getAuth(), $parameters);
        }
        else if(method_exists($this->getClient(), $name)){
            return call_user_func_array(array( $this->getClient(),$name),$parameters);
        }
        return parent::__call($name, $parameters);
    }

    public function init(){
        parent::init();
		Yii::app()->getSession()->open();
        $this->initAuth();
    }

    public function initAuth(){
        if($this->category == self::CATEGORY_SINA){
            if(count($config)==0)
            $config = array('akey'=>$this->akey,'skey'=>$this->skey);
            include dirname(__FILE__).'/sina/saetv2.ex.class.php';
            $this->_auth = new SaeTOAuthV2($config['akey'],$config['skey']);
        }
    }


    public function getAuth(){
        if($this->_auth === null)
            $this->initAuth();
        $auth = $this->_auth;
        $auth->debug = $this->debug;
        return $auth;
    }

    public function setClient($config = array()){
        if(count($config)==0)
            $config = array('akey'=>$this->akey,'skey'=>$this->skey);
        $token = $this->getToken();
        $this->_client = new SaeTClientV2($config['akey'],$config['skey'],$token['access_token']);
    }

    public function getClient(){
        if($this->_client === null)
            $this->setClient ();
        return $this->_client;
    }

    public function  getLoginUrl($callbackUrl = null) {
        if($callbackUrl === null)
            $callbackUrl = $this->callbackUrl;
        $auth = $this->getAuth();
        return $auth->getAuthorizeURL($callbackUrl);
    }

    public function  post($content) {
        $client = $this->getClient();
        $rs = $client->update($content);
        if(isset($rs['error_code']) && $rs['error_code'] > 0)
            return false;
        else
            return true;
    }

    public function setState($key, $value, $defaultValue = null){
        $key=$this->getStateKeyPrefix().$key;
		if($value===$defaultValue)
			Yii::app()->session->add($key,null);
		else
			Yii::app()->session->add($key,$value);
    }

    public function getState($key,$defaultValue = null){
        $key=$this->getStateKeyPrefix().$key;
        $value = Yii::app()->session->get($key);
		return $value;
    }

    public function hasState($key){
        $key=$this->getStateKeyPrefix().$key;
        $value = Yii::app()->session->get($key);
		return isset($value);
    }

    public function clearStates()
	{
		$keys=array_keys($_SESSION);
		$prefix=$this->getStateKeyPrefix();
		$n=strlen($prefix);
		foreach($keys as $key)
		{
			if(!strncmp($key,$prefix,$n))
				unset($_SESSION[$key]);
		}
	}

    public function getStateKeyPrefix()
	{
		if($this->_keyPrefix!==null)
			return $this->_keyPrefix;
		else
			return $this->_keyPrefix=md5('Yii.'.get_class($this).'.'.Yii::app()->getId());
	}

    public function setToken($value){
        $this->setState(self::TOKEN, $value);
    }

    public function getToken(){
        return $this->getState(self::TOKEN);
    }

    /**
     * 处理返回请求，返回授权结果
     * @return boolean 是否授权成功
     */
    public function processRequest(){
        $request = $_REQUEST;
        $keys = array();
        $keys['code'] = $request['code'];
        $keys['redirect_uri'] = $this->callbackUrl;
        try{
            $auth = $this->getAuth();
            $token = $auth->getAccessToken(self::AUTH_TYPE,$keys);
            
        }  catch (OAuthException $e){
            Yii::log("授权失败：".$e->getMessage());
            return false;
        }
        if($token){
            $this->setToken($token);
            setcookie('weibojs_' . $auth->client_id, http_build_query($token));
            return true;
        }else{
            return false;
        }
    }

    public function setReturnUrl($returnUrl){
        $this->_returnUrl = $returnUrl;
    }
    
    public function getReturnUrl(){
        if($this->_returnUrl == '')
            $this->_returnUrl = $this->callbackUrl;
        return $this->_returnUrl;
    }

    public function getUser(){
        $client = $this->client;
        $uid = $client->get_uid();
        $clientUser = $client->show_user_by_id($uid['uid']);
        return $clientUser;
    }
}