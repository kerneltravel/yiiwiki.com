<?php

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $sort
 * @property integer $create_date
 * @property integer $modify_date
 */
class Page extends CActiveRecord
{
    private $_defaultSort = 1;

    /**
	 * Returns the static model of the specified AR class.
	 * @return Page the static model class
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
		return '{{page}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sort, create_date, modify_date', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, sort, create_date, modify_date', 'safe', 'on'=>'search'),
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
			'title' => '标题',
			'content' => '内容',
			'sort' => '排序',
			'create_date' => '创建时间',
			'modify_date' => '修改时间',
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('modify_date',$this->modify_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function  afterConstruct() {
        parent::afterConstruct();
        $this->sort = $this->_defaultSort;
    }

    public function getCreateDate(){
        return Util::date($this->create_date);
    }

    public function getModifyDate(){
        return Util::date($this->modify_date);
    }

    public static function toMenuItem(){
        $models = self::model()->findAll(array('order'=>'sort desc'));
        $items = array();
        foreach($models as $model){
            $items[] = array('label'=>$model->title,'url'=>array('/page/view','id'=>$model->id));
        }

        return $items;
    }

    /**
     * 返回文章内容的摘要
     *
     * 摘要内容时经过 {@linkCMarkdownParser MarkdownParser} 处理以后的内容
     *
     * @param integer $length 摘要的字数
     * @return string 文章内容的摘要
     */
    public function getSummary($length = 100) {
        $markdown = new MarkdownParser();
        $content = $markdown->transform($this->content);
        return Util::substring($content, $length, '');
    }
}