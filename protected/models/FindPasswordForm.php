<?php

class FindPasswordForm extends CFormModel{

    public $username;
    public $verifyCode;
    
    private $_model = null;

    public function rules(){
        return array(
            array('username','check'),
            array('username','safe'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
        );
    }

    public function  attributeLabels() {
        return array(
            'username'=>'用户名或注册时的邮箱',
            'verifyCode'=>'验证码',
        );
    }

    public function check($attribute,$params){
        $model = User::model()->find('LOWER(username)=?', array(strtolower($this->username)));
        if($model === null)
            $this->addError('username', '该用户名不存在');
        else
            $this->_model = $model;
    }

    public function createToken(){
        $model = $this->_model;
        return md5($model->id.$model->username.$model->passwd);
    }

    public function createCode(){
        $model = $this->_model;
        return base64_encode($model->email);
    }

    public function getModel(){
        return $this->_model;
    }

    public function createEmailBody(){
        $content = "
        <font color='red'>尊敬的用户zhangdi5649您好：</font><br />
   您使用了找回密码功能，请点击下面的链接完成密码找回流程，如果无法正确打开页面，请将完整地址复制到浏览器地址栏。<br />
谢谢<br />
".CHtml::link(Yii::app()->createAbsoluteUrl('user/resetPassword',array('token'=>$this->createToken(),'code'=>$this->createCode())),Yii::app()->createAbsoluteUrl('user/resetPassword',array('token'=>$this->createToken(),'code'=>$this->createCode())));
        return Yii::app()->getController()->renderPartial('//layouts/email',array('content'=>$content),true);
    }
}
?>
