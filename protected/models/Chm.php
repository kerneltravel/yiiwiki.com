<?php

/**
 * This is the model class for table "{{chm}}".
 *
 * The followings are the available columns in table '{{chm}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $article_count
 * @property string $url
 * @property integer $create_date
 * @property integer $modify_date
 */
class Chm extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Chm the static model class
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
		return '{{chm}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_count, create_date, modify_date', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('description, url', 'length', 'max'=>255),
            array('name,url','required'),
            array('modify_date','default',
                  'value'=>time(),
                  'setOnEmpty'=>false,'on'=>'update'),
            array('create_date,modify_date','default',
                  'value'=>time(),
                  'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, article_count, url, create_date, modify_date', 'safe', 'on'=>'search'),
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
			'name' => '名称',
			'description' => '描述',
			'article_count' => '文章数',
			'url' => '下载地址',
			'create_date' => '发布时间',
			'modify_date' => '最后修改时间',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('article_count',$this->article_count);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('modify_date',$this->modify_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'modify_date desc,create_date desc'
            )
		));
	}
}