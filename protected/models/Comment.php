<?php

/**
 * 评论的数据模型.
 *
 * 对应表 'comment'
 * 
 * @package application.models
 * @author Di Zhang <zhangdi5649@126.com>
 * 
 * @property integer $id ID
 * @property integer $article_id 文章ID
 * @property integer $user_id 用户ID
 * @property string $content 内容
 * @property integer $create_date 发表时间
 * @property integer $modify_date 修改时间
 * @property string $verifyCode 验证码
 */
class Comment extends CActiveRecord
{
    /**
     * 验证码
     * @var string 验证码
     */
    public $verifyCode;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Comment the static model class
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
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_id, user_id, create_date, modify_date', 'numerical', 'integerOnly'=>true),
			array('content', 'required'),
            array('content','length','min'=>6),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, article_id, user_id, content, create_date, modify_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关系规则.
	 */
	public function relations()
	{
		return array(
            'article'=>array(self::BELONGS_TO, 'Article', 'article_id'),
            'author'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array 自定义属性标签(name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'article_id' => '文章',
			'user_id' => '用户',
			'content' => '评论',
			'create_date' => '发表时间',
			'modify_date' => '最后修改时间',
            'verifyCode' =>'验证码'
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('modify_date',$this->modify_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 保存(save)之前的事件
     * @return boolean 保存(save)是否可以执行
     */
    protected function beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->create_date = $this->modify_date = time();
                $this->user_id = Yii::app()->user->id;
            }else
                $this->modify_date = time();
            return true;
        }else{
            return false;
        }
    }

    /**
	 * @param Article 评论所属的文章. 为空时此方法会根据 {@link Comment::relations 关系} 查询出来.
	 * @return string 此评论的链接
	 */
	public function getUrl($article=null)
	{
		if($article===null)
			$article=$this->article;
		return $article->url.'#c'.$this->id;
	}

    /**
	 * @return string 发表评论的作者的链接
	 */
	public function getAuthorLink()
	{
        return $this->author->getNameLink();
	}

    /**
     * 返回指定格式的时间(最后修改时间 modify_date)
     * 
     * @param string $format 指定的时间格式, 默认为 'Y-m-d H:i'
     * @return string 指定格式的时间
     */
    public function getDate($format = 'Y-m-d H:i'){
        return date($format, $this->modify_date);
    }

    /**
     * 返回摘要
     * 
     * @return string 文章内容的摘要
     */
    public function getSummary(){
        $markdown = new CMarkdownParser();
        $content = $markdown->transform($this->content);
        return $content;
    }

}