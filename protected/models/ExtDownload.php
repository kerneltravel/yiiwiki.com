<?php

/**
 * This is the model class for table "{{ext_download}}".
 *
 * The followings are the available columns in table '{{ext_download}}':
 * @property integer $id
 * @property integer $ext_id
 * @property string $download_url
 * @property string $name
 * @property integer $create_date
 */
class ExtDownload extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ExtDownload the static model class
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
		return '{{ext_download}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ext_id, create_date', 'numerical', 'integerOnly'=>true),
			array('download_url, name', 'length', 'max'=>255),
            array('ext_id,download_url,name','required'),
            array('download_url','url'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ext_id, download_url, name, create_date', 'safe', 'on'=>'search'),
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
			'ext_id' => 'Ext',
			'download_url' => '下载地址',
			'name' => '说明',
			'create_date' => '创建时间',
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
		$criteria->compare('ext_id',$this->ext_id);
		$criteria->compare('download_url',$this->download_url,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('create_date',$this->create_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function  beforeSave() {
        if(parent::beforeSave()){
            $this->create_date = time();
            return true;
        }else
            return false;
    }

    public function getCreateDate(){
        return Util::date($this->create_date);
    }
}