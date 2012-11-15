<?php

/**
 * 用户辅助表模型
 *
 * 对应表 'user_option'
 *
 * The followings are the available columns in table '{{user_option}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $key
 * @property string $value
 */
class UserOption extends CActiveRecord
{
    const KEY_WEIBO_SINA_ID = '_weibo_sina_id';

    public $keys = array(
        self::KEY_WEIBO_SINA_ID =>'新浪微博ID',
        self::KEY_CREDIT=>'积分',
    );

	/**
	 * Returns the static model of the specified AR class.
	 * @return UserOption the static model class
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
		return '{{user_option}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('key', 'length', 'max'=>45),
			array('value', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, key, value', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO, 'User', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'key' => 'Key',
			'value' => 'Value',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function hasBindWeiboForUser($userId){
        return self::model()->exists('user_id=? and `key`=?',array($userId,self::KEY_WEIBO_SINA_ID));
    }

    public static function hasBindWeiboOfSina($sinaUid){
        return self::has($sinaUid, self::KEY_WEIBO_SINA_ID);
    }

    public static function hasSinaWeiboById($sinaUid){
        return self::model()->exists('`key`=? and `value`=?',array(self::KEY_WEIBO_SINA_ID,$sinaUid));
    }

    public static function has($user_id,$key){
        return self::model()->exists('user_id=:user_id and key=:key',array(':user_id'=>$user_id,':key'=>$key));
    }
}