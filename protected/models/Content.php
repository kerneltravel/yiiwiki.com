<?php

/**
 * This is the model class for table "{{content}}".
 *
 * The followings are the available columns in table '{{content}}':
 * @property integer $id
 * @property integer $article_id
 * @property string $title
 * @property integer $category
 * @property integer $user_id
 * @property string $content
 * @property string $tags
 * @property integer $create_date
 * @property string $summary
 * @property integer $revision
 */
class Content extends CActiveRecord
{
    const INIT_SUMMARY = '初始化版本';

    /**
	 * Returns the static model of the specified AR class.
	 * @return Content the static model class
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
		return '{{content}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_id, category, user_id, create_date, revision', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('tags', 'length', 'max'=>255),
			array('summary', 'length', 'max'=>128),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, article_id, title, category, user_id, content, tags, create_date, summary, revision', 'safe', 'on'=>'search'),
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
            'article'=>array(self::BELONGS_TO, 'Article', 'article_id'),
            'author'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'article_id' => '文章',
			'title' => '标题',
			'category' => '分类',
			'user_id' => '作者',
			'content' => '内容',
			'tags' => '标签',
			'create_date' => '创建时间',
			'summary' => '修订摘要',
			'revision' => '修订版本',
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
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('category',$this->category);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('revision',$this->revision);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function  beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->create_date = time();
                $this->revision = $this->article->getLastVersion()+1;
                $this->user_id = Yii::app()->user->id;
            }
            return true;
        }else
            return false;
    }

    public function getCreateDate(){
        return Util::date($this->create_date);
    }

}