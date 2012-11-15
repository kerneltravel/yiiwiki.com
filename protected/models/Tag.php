<?php

/**
 * 标签的数据模型
 *
 * 对应表 'tag'
 *
 * @author Di Zhang <zhangdi5649@126.com>
 *
 * @property integer $id 标签 ID
 * @property string $name 标签名
 * @property integer $frequency 出现频率,可表示有此标签的文章数
 */
class Tag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tag the static model class
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
		return '{{tag}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, frequency', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, frequency', 'safe', 'on'=>'search'),
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
			'id' => 'Id',
			'name' => '标签名',
			'frequency' => '频率',
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

		$criteria->compare('frequency',$this->frequency);

		return new CActiveDataProvider('TagAR', array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 返回标签名和它们对应的权重
     * 只有权重最高的才会返回
	 * @param integer 返回的最大数量
	 * @return array 标签名为索引的权重数组.
	 */
	public function findTagWeights($limit=20)
	{
		$models=$this->findAll(array(
			'order'=>'frequency DESC',
			'limit'=>$limit,
		));

		$total=0;
		foreach($models as $model)
			$total+=$model->frequency;

		$tags=array();
		if($total>0)
		{
			foreach($models as $model)
				$tags[$model->name]=8+(int)(16*$model->frequency/($total+10));
			ksort($tags);
		}
		return $tags;
	}

	/**
     * 根据关键字匹配存在的标签
	 * @param string 需要匹配的关键字
	 * @param integer 返回的最多数量
	 * @return array 匹配的标签名列表
	 */
	public function suggestTags($keyword,$limit=20)
	{
		$tags=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'frequency DESC, Name',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($tags as $tag)
			$names[]=$tag->name;
		return $names;
	}

    /**
     * 字符串转化为数组
     * @param string $tags 逗号分隔的标签
     * @return array 标签名组成的数组
     */
	public static function string2array($tags)
	{
		return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
	}

    /**
     * 数组转化为字符串
     * @param array $tags 标签名组成的数组
     * @return string 逗号分隔的标签
     */
	public static function array2string($tags)
	{
		return implode(', ',$tags);
	}

    /**
     * 更新标签出现的频率
     * @param string $oldTags 旧标签
     * @param string $newTags 新标签
     */
	public function updateFrequency($oldTags, $newTags)
	{
        
        $oldTags=self::string2array($oldTags);
		$newTags=self::string2array($newTags);
		$this->addTags(array_values(array_diff($newTags,$oldTags)));
		$this->removeTags(array_values(array_diff($oldTags,$newTags)));
	}

    /**
     * 添加标签
     * @param array $tags 标签名组成的数组
     */
	public function addTags($tags)
	{
		$criteria=new CDbCriteria;
		$criteria->addInCondition('name',$tags);
		$this->updateCounters(array('frequency'=>1),$criteria);
		foreach($tags as $name)
		{
			if(!$this->exists('name=:name',array(':name'=>$name)))
			{
				$tag=new Tag;
				$tag->name=$name;
				$tag->frequency=1;
				$tag->save();
			}
		}
	}

    /**
     * 移除标签
     * @param array $tags 标签名组成的数组
     */
	public function removeTags($tags)
	{
		if(empty($tags))
			return;
		$criteria=new CDbCriteria;
		$criteria->addInCondition('name',$tags);
		$this->updateCounters(array('frequency'=>-1),$criteria);
		$this->deleteAll('frequency<=0');
	}

    /**
     * 返回标签的 url 地址
     * @return string
     */
    public static function getUrl($tag){
        return Yii::app()->createUrl('/site/tag',array('tag'=>$tag));
    }

}
