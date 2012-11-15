<?php

/**
 * This is the model class for table "{{module}}".
 *
 * The followings are the available columns in table '{{module}}':
 * @property integer $id
 * @property string $name
 * @property string $screen_name
 * @property string $description
 * @property integer $status
 * @property string $theme
 * @property string $option
 */
class Module extends CActiveRecord
{
    /**
     * 选项数组
     * @var array
     */
    public $options = array();
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public static $statuses = array(
        self::STATUS_DISABLED => '禁用',
        self::STATUS_ENABLED => '启用',
    );
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Module the static model class
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
		return '{{module}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('name, screen_name, theme', 'length', 'max'=>45),
			array('description', 'length', 'max'=>255),
			array('option,options', 'safe'),
            array('name','unique'),
            array('name','moduleExists'),
            array('name,screen_name,status','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, screen_name, description, status, theme, option', 'safe', 'on'=>'search'),
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
			'name' => '模块ID',
			'screen_name' => '名称',
			'description' => '描述',
			'status' => '状态',
			'theme' => '主题',
			'option' => '选项(key=>value 值对)',
            'statusName'=>'状态',
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
		$criteria->compare('screen_name',$this->screen_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('theme',$this->theme,true);
		$criteria->compare('option',$this->option,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function  beforeSave() {
        if(parent::beforeSave()){
            if(count($this->options)>0){
                $this->option = json_encode($this->options);
            }else{
                $this->option = "";
            }
            return true;
        }else
            return false;
    }

    public function moduleExists($attribute,$param){
        if(isset($this->options['class'])){
            if(!file_exists (Yii::getPathOfAlias($this->options['class']).'.php'))
                $this->addError ('option', 'class 属性指定的文件不存在,请先上传');
        }elseif(!is_dir($this->getModulePath().'/'.$this->name))
            $this->addError ('name', '该模块文件不存在,请先上传');
    }

    public function getModulePath(){
        return Yii::app()->basePath.'/modules';
    }
    public function getStatusName(){
        return self::$statuses[$this->status];
    }

    public function getStatusNameWithColor(){
        if($this->status == self::STATUS_DISABLED)
            $color = 'red';
        else if($this->status == self::STATUS_ENABLED)
            $color = 'green';
        else
            $color = 'gray';
        return CHtml::tag('font',array('color'=>$color),$this->getStatusName());
    }
    
    public function getIsEnabled(){
        return $this->status == self::STATUS_ENABLED;
    }

    public function getOptions(){
        $options['enabled'] = $this->getIsEnabled();
        if(!empty ($this->theme))
            $options['theme'] = $this->theme;
        if(!empty ($this->option))
            $options = array_merge($options, CJSON::decode($this->option));
        return $options;
    }

    public static function getModuleIsEnabled($moduleId){
        $model = self::model()->find('name=?',array($moduleId));
        if($model !== null)
            return $model->getIsEnabled ();
        else
            return false;
    }

    protected function  afterFind() {
        $options = CJSON::decode($this->option);
        if(!is_array($options))
            $options = array();
        $this->options = $options;
    }

    public function getOptionsForm(){
        $row = '';
        foreach ($this->options as $key=>$value){
            $row .= CHtml::textField('Options[key][]',$key,array('size'=>15));
            $row .= "&nbsp;&nbsp;=>&nbsp;&nbsp;";
            $row .= CHtml::textField('Options[value][]',$value,array('size'=>15)).'<br />';
        }
        return $row;
    }

    public function getOptionsView(){
        $options = array();
        foreach ($this->options as $key=>$value){
            $options[] = $key.'=>'.$value;
        }
        return implode('<br />', $options);
    }

    public function getOptionRowForm(){
        $row = '';
		$row .= CHtml::textField('Options[key][]','',array('size'=>15));
        $row .= "&nbsp;&nbsp;=>&nbsp;&nbsp;";
        $row .= CHtml::textField('Options[value][]','',array('size'=>15)).'<br />';
        return $row;
    }
}