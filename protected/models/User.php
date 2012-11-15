<?php

/**
 * 用户的数据模型
 *
 * @author Di Zhang <zhangdi5649@126.com>
 * @package application.models
 * 
 * @property integer $id 用户 ID
 * @property string $username 用户名
 * @property string $passwd 密码，经过加密
 * @property string $nickname 昵称
 * @property string $email 邮件
 * @property string $gender 性别
 * @property integer $credit 积分
 * @property integer $reg_date 注册时间
 * @property integer $modify_date 修改时间
 */
class User extends CActiveRecord
{
    const CREDIT_INIT = 20;
    const CREDIT_NEW_ARTICLE = 10;
    const CREDIT_NEW_COMMENT = 2;
    const CREDIT_DELETE_ARTICLE = 10;
    const CREDIT_DELETE_COMMENT = 2;

    /**
     * 表单中的密码
     * @var string 表单中的密码，未经过加密
     */
    public $passwd1;

    /**
     * 表单中的确认密码
     * @var string 表单中的密码，未经过加密
     */
    public $passwd2;

    /**
     * 表单中的旧密码， 修改密码时使用
     * @var string 表单中的密码，未经过加密
     */
    public $oldPasswd;

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_SECRECY = 'secrecy';

    /**
     * @var array 性别，数组中的键为标识ID，值为性别
     */
    public static $_genders = array(
        self::GENDER_SECRECY=>'保密',
        self::GENDER_MALE=>'男',
        self::GENDER_FEMALE=>'女',
    );

    public static $searchGenders = array(
        null=>'',
        self::GENDER_SECRECY=>'保密',
        self::GENDER_MALE=>'男',
        self::GENDER_FEMALE=>'女',
    );

    private $_oldPassword;

    /**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reg_date, modify_date', 'numerical', 'integerOnly'=>true),
			array('username, passwd', 'length', 'max'=>45),
			array('nickname', 'length', 'max'=>20),
			array('email', 'length', 'max'=>100),
			array('gender', 'length', 'max'=>7),

            array('nickname,email,gender','required'),

            array('username, passwd1','required','on'=>'register'),
            array('username','length','min'=>6,'max'=>15),
            array('username','unique'),
            array('email','unique','message'=>'该邮箱已经注册，请使用其他邮箱','on'=>'register,edit'),
            array('nickname','length','min'=>2,'max'=>10),
            array('email','email'),
            array('passwd2','compare','compareAttribute'=>'passwd1','message'=>'确认密码和密码不一致','on'=>'register,changePassword,resetPassword'),

            array('passwd1, passwd2, oldPasswd','required','on'=>'changePassword'),
            array('oldPasswd','checkOldPassword','on'=>'changePassword'),

            array('passwd1, passwd2','required','on'=>'resetPassword'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, credit,passwd, passwd1, passwd2, nickname, email, gender, reg_date, modify_date', 'safe', 'on'=>'search'),
            array('id,username,passwd','unsafe','on'=>'adminChange'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'articleCount'=>array(self::STAT, 'Article', 'user_id'),
            'commentCount'=>array(self::STAT, 'Comment', 'user_id'),
            'articles'=>array(self::HAS_MANY,'Article','user_id'),
            'comments'=>array(self::HAS_MANY, 'Comment', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => '用户名',
			'passwd' => '密码',
            'passwd1' => '密码',
			'nickname' => '昵称',
			'email' => '邮箱',
			'gender' => '性别',
			'reg_date' => '注册时间',
			'modify_date' => '最后修改时间',
            'passwd2'=>'确认密码',
            'oldPasswd'=>'原密码',
            'articleCount'=>'发布文章数量',
            'credit'=>'积分'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('passwd',$this->passwd,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('reg_date',$this->reg_date);
		$criteria->compare('modify_date',$this->modify_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'modify_date desc'
            )
		));
	}

    /**
     * {@link User::save 保存} 记录调用
     * @return boolean 保存是否可以执行
     */
    protected function  beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->reg_date = $this->modify_date = time();
                $this->passwd = $this->hasPassword($this->passwd1);
                $this->credit = 0;
            }else
                $this->modify_date = time();
            if($this->getScenario() == 'changePassword' || $this->getScenario() == 'resetPassword'){
                $this->passwd = $this->hasPassword($this->passwd1);
            }
            return true;
        }else
            return false;
    }

    /**
     * 模型内部验证规则
     *
     * 验证旧密码是否正确
     * 
     * @param string $attribute 属性
     * @param array $params 参数
     */
    public function checkOldPassword($attribute,$params){
        if(!$this->validatePassword($this->oldPasswd))
            $this->addError ($attribute, '原密码不正确');
    }

    /**
     * 密码加密
     * @param string $password 需要加密的密码
     * @return string 加密后的密码
     */
    public function hasPassword($password){
        return md5($password);
    }

    /**
     * 验证密码是否一致
     * @param string 需要验证的密码
     * @return boolean
     */
    public function validatePassword($password){
        return $this->passwd === $this->hasPassword($password);
    }

    /**
     * 在使用 {@link User::find find()} 填充数据时调用
     */
    protected function afterFind() {
        parent::beforeFind();
        $this->_oldPassword = $this->passwd;
    }

    /**
     * @return string 性别
     */
    public function getGenderName(){
        return self::$_genders[$this->gender];
    }

    /**
     * 返回指定格式的注册时间
     * 
     * @param string $format 指定的时间格式，默认为 'Y年m月d日 H时i分'
     * @return string 指定格式的时间
     */
    public function getRegDate($format = "Y年m月d日 H时i分"){
        return date($format,$this->reg_date);
    }

    /**
     * 返回指定格式的最后修改时间
     * @param string $format 指定的时间格式，默认为 'Y年m月d日 H时i分'
     * @return string 指定格式的时间
     */
    public function getModifyDate($format = "Y年m月d日 H时i分"){
        return date($format,$this->modify_date);
    }

    /**
     * 返回个人中心的 URL
     * @return string 个人中心的 URL
     */
    public function getHomeUrl(){
        //return Yii::app()->createUrl('user/home',array('id'=>$this->id));
        if(Module::getModuleIsEnabled('space'))
            return Yii::app()->createUrl('/space/default/index',array('uid'=>$this->id));
        else
            return Yii::app()->createUrl('user/home',array('id'=>$this->id));

    }

    /**
     * 返回用户昵称的链接
     *
     * 链接名为用户昵称，链接地址为用户 {@link User::getHomeUrl 个人中心地址}
     * @param array $htmlOptions 链接的 HTML 属性，默认为 array()
     * @return string 用户昵称的链接
     */
    public function getNameLink($htmlOptions = array()){
        return CHtml::link($this->nickname,$this->getHomeUrl(),$htmlOptions);
    }

    public function plusCredit($credit, $reason){
        $this->credit += $credit;
        if($this->save()){
            $log = new CreditLog;
            $log->credit = $credit;
            $log->type = CreditLog::TYPE_PLUS;
            $log->user_id = $this->id;
            $log->reason = $reason;
             $log->save();
             echo CHtml::errorSummary($log);
        }else
            return false;
    }

    public function minuxCredit($credit, $reason){
        $this->credit -= $credit;
        if($this->save()){
            $log = new CreditLog;
            $log->credit = $credit;
            $log->type = CreditLog::TYPE_MINUX;
            $log->user_id = $this->id;
            $log->reason = $reason;
            return $log->save();
        }else
            return false;
    }

    public function getSpaceUrl(){
        return Yii::app()->createUrl('/space/default/index',array('uid'=>$this->id));
    }

    public function initCredit(){
        //删除日志
        CreditLog::model()->deleteAll('user_id=:user_id',array(':user_id'=>  $this->id));
        $credit = 0;
        $this->credit = 0;
        $articleCount = $this->articleCount;
        $commentCount = $this->commentCount;
        //注册积分
        $this->plusCredit(self::CREDIT_INIT, CreditLog::REASON_INIT);
        //文章
        for($i=0;$i<$articleCount;$i++)
            $this->plusCredit(self::CREDIT_NEW_ARTICLE, CreditLog::REASON_NEW_ARTICLE);
        //回复
        for($i=0;$i<$commentCount;$i++)
            $this->plusCredit(self::CREDIT_NEW_ARTICLE, CreditLog::REASON_NEW_COMMENT);
    }
}