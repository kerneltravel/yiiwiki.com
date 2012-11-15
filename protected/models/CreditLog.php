<?php

/**
 * This is the model class for table "{{credit_log}}".
 *
 * The followings are the available columns in table '{{credit_log}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $credit
 * @property integer $reason
 * @property integer $create_date
 */
class CreditLog extends CActiveRecord
{
    const TYPE_PLUS = 1;
    const TYPE_MINUX  = 2;

    const REASON_INIT = 1;
    const REASON_NEW_ARTICLE = 2;
    const REASON_NEW_COMMENT = 3;
    const REASON_DELETE_ARTICLE = 4;
    const REASON_DELETE_COMMENT = 5;
	/**
	 * Returns the static model of the specified AR class.
	 * @return CreditLog the static model class
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
		return '{{credit_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type, credit, reason, create_date', 'numerical', 'integerOnly'=>true),
            array('create_date','default',
                  'value'=>time(),
                  'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, type, credit, reason, create_date', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'type' => 'Type',
			'credit' => 'Credit',
			'reason' => 'Reason',
			'create_date' => 'Create Date',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('reason',$this->reason);
		$criteria->compare('create_date',$this->create_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}