<?php

/**
 * This is the model class for table "{{article}}".
 *
 * The followings are the available columns in table '{{article}}':
 * @property integer $id
 * @property string $title
 * @property integer $category
 * @property integer $type
 * @property integer $user_id
 * @property string $content
 * @property integer $create_date
 * @property integer $modify_date
 * @property string $tags
 * @property integer $hits
 */
class News extends ArticleAR
{
    const CATEGORY_TYPE = 'NewsCategory';

    const CATEGORY_INFO = 1;
    const CATEGORY_NOTICE = 2;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
		$criteria->compare('category',$this->category);
		$criteria->addColumnCondition(array('type'=>self::TYPE_NEWS));
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('modify_date',$this->modify_date);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('hits',$this->hits);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'modify_date desc,create_date desc'
            )
		));
	}

    protected function  beforeSave() {
        if(parent::beforeSave()){
            $this->type = self::TYPE_NEWS;
            return true;
        }else
            return false;
    }

    protected function  beforeFind() {
        parent::beforeFind();
        $this->getDbCriteria()->addColumnCondition(array('type'=>self::TYPE_NEWS));
    }

    /**
     * 返回分类名
     * @return string 分类名
     */
    public function getCategoryName() {
        return Lookup::item(self::CATEGORY_TYPE, $this->category);
    }

    /**
     * 创建分类的 URL 地址
     * @param integer $category 分类的ID
     * @return string  URL 地址
     */
    public static function createCategoryUrl($category) {
        $category = (int) $category;
        return Yii::app()->createUrl('/news/index', array('category' => $category, 'name' => Lookup::item(self::CATEGORY_TYPE, $category)));
    }

    /**
     * 返回分类的 URL 地址
     * @return string URL 地址
     */
    public function getCategoryUrl() {
        return self::createCategoryUrl($this->category);
    }

    /**
     * 返回分类的链接
     * @return string 分类的链接
     */
    public function getCategoryLink($htmlOptions = array()) {
        return CHtml::link($this->getCategoryName(), $this->getCategoryUrl(), $htmlOptions);
    }

    /**
     * 返回指定分类下的文章数量
     * @param integer $category 分类 ID
     * @return integer 文章数量
     */
    public static function getCountByCategory($category) {
        return self::model()->count('category = :category and type=:type', array(':category' => $category,':type'=>self::TYPE_NEWS));
    }

    public static function getNewestNotice(){
        $cr = new CDbCriteria;
        $cr->addColumnCondition(array('category'=>self::CATEGORY_NOTICE));
        $cr->order = 'modify_date desc';
        $model = self::model()->find($cr);
        if($model===null)
            $model = self::model();
        return $model;
    }
}