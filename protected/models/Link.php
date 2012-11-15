<?php

/**
 * This is the model class for table "{{link}}".
 *
 * The followings are the available columns in table '{{link}}':
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property string $email
 * @property integer $create_date
 * @property integer $modify_date
 * @property integer $oldStatus 旧状态
 */
class Link extends CActiveRecord
{
    const TYPE = 'LinkStatus';
    const ADMIN_TYPE = "AdminLinkStatus";
    
    const STATUS_PENDING=1;
	const STATUS_APPROVED=2;
    const STATUS_FAIL = -1;

    public $oldStatus;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Link the static model class
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
		return '{{link}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, create_date, modify_date', 'numerical', 'integerOnly'=>true),
			array('url, email', 'length', 'max'=>255),
			array('title', 'length', 'max'=>128),
			array('description', 'safe'),
            array('url,title,description,email','required'),
            array('email','email'),
            array('url','unique','message'=>'该网站已经申请过，请不要重复申请.'),
            array('url','url','message'=>'请填写正确的 URL 地址.'),
            array('description','length','min'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, title, description, status, email, create_date, modify_date', 'safe', 'on'=>'search'),
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
			'url' => '网站地址',
			'title' => '网站名',
			'description' => '网站描述',
			'status' => '状态',
			'email' => '申请人邮箱',
			'create_date' => '创建时间',
			'modify_date' => '修改时间',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('modify_date',$this->modify_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'status asc,modify_date asc,create_date asc'
            ),
		));
	}

    protected function  beforeSave() {
        if(parent::beforeSave()){
            if(empty ($this->status))
                $this->status = self::STATUS_PENDING;
            return true;
        }else
            return false;
    }

    public function behaviors() {
        return array(
            'AutoTimestampBehavior' => array(
                'class' => 'AutoTimestampBehavior',
            )
        );
    }

    protected function  afterFind() {
        parent::afterFind();
        $this->oldStatus = $this->status;
    }

    public function getLink(){
        return CHtml::link($this->title,$this->getUrl(),array('target'=>'_blank','id'=>'link-'.$this->id));
    }

    public function getUrl(){
        return $this->url;
    }

    public function getStatus(){
        return Lookup::item(self::ADMIN_TYPE, $this->status);
    }

    public function getStatusView(){
        $color = $this->status == self::STATUS_APPROVED ? 'green' :( $this->status == self::STATUS_FAIL ?'grey': 'red');
        return CHtml::tag('font',array('color'=>$color),$this->getStatus());
    }

    public function getCreateDate(){
        return Util::date($this->create_date);
    }

    public function getModifyDate(){
        return Util::date($this->modify_date);
    }

    public static function getAll(){
        return self::model()->findAll();
    }

    public static function getAllApproved(){
        return self::model()->findAll('status=:status',array(':status'=>self::STATUS_APPROVED));
    }


    public static function getAllLinks(){
        $models = self::getAll();
        $links = array();
        foreach($models as $model){
            $links[] = $model->getLink();
        }

        return $links;
    }

    public static function modelsToLinks($models){
        $links = array();
        foreach($models as $model){
            $links[] = $model->getLink();
        }

        return $links;
    }


}