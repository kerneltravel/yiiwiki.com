<?php

/**
 * 文章的数据模型.
 *
 * 对应表 'article'
 *
 * @package application.models
 * @author Di Zhang <zhangdi5649@126.com>
 * 
 * @property integer $id 文章 ID
 * @property string $title 文章标题
 * @property integer $category 文章分类 ID
 * @property integer $user_id 文章作者 ID
 * @property string $content 文章内容
 * @property integer $create_date 文章的创建时间
 * @property integer $modify_date 文章的最后修改时间
 * @property string $tags 文章的标签
 * @property integer $hits 文章的点击量
 * @property string $summary 修订摘要
 */
class Article extends ArticleAR {

    const CATEGORY_TYPE = 'WikiCategory';

    const CATEGORY_TIPS = 1;
    const CATEGORY_HOW_TOS = 2;
    const CATEGORY_TUTORIALS = 3;
    const CATEGORY_FAQS = 4;
    const CATEGORY_OTHERS = 5;

    public $summary;
    /**
     * 返回指定的 AR 类的静态模型.
     * @return Article 静态模型类
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string 对应的表名
     */
    public function tableName() {
        return '{{article}}';
    }

    public function rules() {
        return CMap::mergeArray(parent::rules(),array(
            array('summary','required','on'=>'update'),
            array('user_id','unsafe','on'=>'update')
        ));
    }

    public function  attributeLabels() {
        return CMap::mergeArray(parent::attributeLabels(),array(
            'summary'=>'修订摘要'
        ));
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('category', $this->category);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('hits', $this->hits);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('create_date', $this->create_date);
        $criteria->compare('modify_date', $this->modify_date);
        $criteria->compare('tags', $this->tags, true);
        $criteria->addColumnCondition(array('type'=>self::TYPE_WIKI));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'modify_date desc,create_date desc'
            ),
        ));
    }

    protected function  beforeFind() {
        parent::beforeFind();
        $this->getDbCriteria()->addColumnCondition(array('type'=>self::TYPE_WIKI));
    }

    protected function  beforeSave() {
        if(parent::beforeSave()){
            $this->type = self::TYPE_WIKI;
            if($this->isNewRecord)
                $this->user_id = Yii::app()->user->id;
            return true;
        }else
            return false;
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
        return Yii::app()->createUrl('/wiki/index', array('category' => $category, 'name' => Lookup::item(self::CATEGORY_TYPE, $category)));
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
        return self::model()->count('category = :category and type=:type', array(':category' => $category,':type'=>self::TYPE_WIKI));
    }

    public function getRatingView() {
        $thumbUpCount = UserFav::getThumbUpCount($this->id);
        $thumbDownCount = UserFav::getThumbDownCount($this->id);
        $rs = array();
        if ($thumbUpCount > 0)
            $rs[] = CHtml::tag('font', array('color' => 'green'), '+ ' . $thumbUpCount);
        if ($thumbDownCount > 0)
            $rs[] = CHtml::tag('font', array('color' => 'red'), '- ' . $thumbDownCount);
        if (count($rs) > 0)
            return ' - ( ' . implode(' / ', $rs) . ' )';
        else
            return;
    }

    public function getRating() {
        $thumbUpCount = UserFav::getThumbUpCount($this->id);
        $thumbDownCount = UserFav::getThumbDownCount($this->id);
        $rs = array();
        $rs[] = CHtml::tag('font', array('color' => 'green'), $thumbUpCount);
        $rs[] = CHtml::tag('font', array('color' => 'red'), $thumbDownCount);
        return implode(' / ', $rs);
    }

    /**
     * 返回文章的最后修订版本号
     * @return integer 版本号
     */
    public function getLastVersion(){
        $model = $this->getLastVersionModel();
        if($model === null){
            return 0;
        }
        return $model->revision;
    }

    /**
     * 返回文章最后修改的版本模型对象
     * @return Content 最后修改版本模型对象
     */
    public function getLastVersionModel(){
        $record = Content::model()->find('article_id=:article_id order by revision desc',array(':article_id'=>$this->id));
        return $record;
    }

    /**
     * 创建新的修订版本
     * @return boolean 返回是否创建成功
     */
    public function createNewRevision(){
        $record = new Content;
        $record->article_id = $this->id;
        $record->category = $this->category;
        $record->content = $this->content;
        $record->tags = $this->tags;
        $record->summary = $this->summary;
        $record->title = $this->title;
        return $record->save();
    }

    public static function isChanged($oldModel,$newModel){
        $title = TextDiff::compare($oldModel->title, $newModel->title);
        $category = TextDiff::compare($oldModel->category, $newModel->category);
        $tags = TextDiff::compare($oldModel->tags, $newModel->tags);
        $content = TextDiff::compare($oldModel->content, $newModel->content);

        return !(empty($title) && empty($category) && empty($tags) && empty ($content));
    }

}