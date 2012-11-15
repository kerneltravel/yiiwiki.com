<?php

/**
 * This is the model class for table "{{admin}}".
 *
 * The followings are the available columns in table '{{admin}}':
 * @property integer $id
 * @property string $username
 * @property string $passwd
 */
class Admin extends CActiveRecord
{

    public $passwd1;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Admin the static model class
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
		return '{{admin}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, passwd', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, passwd', 'safe', 'on'=>'search'),
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
            'passwd1'=>'密码'
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * {@link Admin::save 保存} 记录调用
     * @return boolean 保存是否可以执行
     */
    protected function  beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->passwd = $this->hasPassword($this->passwd1);
            }
            return true;
        }else
            return false;
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
}