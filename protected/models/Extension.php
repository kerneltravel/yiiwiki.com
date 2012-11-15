<?php

/**
 * This is the model class for table "{{extension}}".
 *
 * The followings are the available columns in table '{{extension}}':
 * @property integer $id
 * @property string $name
 * @property integer $category
 * @property string $content
 * @property string $demo_url
 * @property string $project_url
 * @property string $tags
 * @property integer $create_date
 * @property integer $modify_date
 * @property integer $hits
 * @property string $summary
 */
class Extension extends CActiveRecord
{
    protected $_oldTags;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Extension the static model class
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
		return '{{extension}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category, create_date, modify_date,hits', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
            array('summary','length','max'=>128),
			array('demo_url, project_url, tags', 'length', 'max'=>255),
			array('content', 'safe'),
            array('name','required','on'=>'insert'),
            array('name','unique','on'=>'insert'),
            array('name','match','pattern'=>'/^[a-z0-9\-_]+$/','on'=>'insert'),
            array('name','length','min'=>6,'on'=>'insert'),
            array('demo_url,project_url','url'),

            array('content, summary','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, category, summary, hits, content, demo_url, project_url, tags, create_date, modify_date', 'safe', 'on'=>'search'),
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
            'files'=>array(self::HAS_MANY,'ExtDownload','ext_id'),
		);
	}

    public function behaviors() {
        return array(
            'AutoTimestampBehavior' => array(
                'class' => 'AutoTimestampBehavior',
            )
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
			'category' => '分类',
			'content' => '内容',
			'demo_url' => '演示地址',
			'project_url' => '项目地址',
			'tags' => '标签',
			'create_date' => '创建时间',
			'modify_date' => '修改时间',
            'hits'=>'浏览',
            'summary'=>'摘要(简介)',
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
		$criteria->compare('category',$this->category);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('demo_url',$this->demo_url,true);
		$criteria->compare('project_url',$this->project_url,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('modify_date',$this->modify_date);
        $criteria->compare('hits',$this->hits);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function  afterConstruct() {
        parent::afterConstruct();
        $this->content = <<<EOF
...扩展的概述...

## 需求

...使用此扩展的需求 (e.g. Yii 1.1 或以上)...

## 用法

...怎么使用这个扩展...

...可以使用类似于下面的代码...

~~~
[php]
\$model=new User;
\$model->save();
~~~

EOF;
    }

    /**
     * 返回标签链接数组
     * @return array 由标签的链接组成的数组
     */
    public function getTagLinks() {
        $links = array();
        foreach (Tag::string2array($this->tags) as $tag)
            $links[] = CHtml::link(CHtml::encode($tag), Tag::getUrl($tag));
        return $links;
    }

    /**
     * 序列化用户输入的标签
     */
    public function normalizeTags($attribute, $params) {
        $this->tags = Tag::array2string(array_unique(Tag::string2array($this->tags)));
    }

    /**
     * 在使用 {@link ArticleAR::find find()} 填充数据时调用
     */
    protected function afterFind() {
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }

    /**
     * 在 {@link ArticleAR::save 保存} 记录后调用
     */
    protected function afterSave() {
        parent::afterSave();
        Tag::model()->updateFrequency($this->_oldTags, $this->tags);
    }

    /**
     * 在 {@link ArticleAR::delete 删除} 记录后调用
     */
    protected function afterDelete() {
        parent::afterDelete();
        Tag::model()->updateFrequency($this->tags, '');
    }

    protected function  beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->hits = 0;
            }
            return true;
        }else
            return false;
    }

    public function getUrl(){
        return Yii::app()->createUrl('/extension/view',array('name'=>$this->name));
    }

    public function getCreateDate(){
        return Util::date($this->create_date);
    }

    public function getModifyDate(){
        return Util::date($this->modify_date);
    }

    /**
     * 返回摘要
     *
     * @return string 文章内容的摘要
     */
    public function getSummary(){
        return CHtml::encode($this->summary);
    }

    public function getNext(){
        return self::model()->find('id > :id',array(':id'=>$this->id));
    }

    public function getPrev(){
        return self::model()->find('id < :id',array(':id'=>$this->id));
    }

    public function getNextLink(){
        $record = $this->getNext();
        if($record === null)
            return "没有了";
        return CHtml::link($record->name,array('/extension/view','name'=>$record->name));
    }

    public function getPrevLink(){
        $record = $this->getPrev();
        if($record === null)
            return "没有了";
        return CHtml::link($record->name,array('/extension/view','name'=>$record->name));
    }
}