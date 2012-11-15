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
class ArticleAR extends CActiveRecord {
    const TYPE_TYPE = "ArticleType";
    const CATEGORY_TYPE = 'ArticleCategory';

    const TYPE_WIKI = 0;
    const TYPE_NEWS = 1;

    /**
     *
     * @var boolean 是否发送到微博
     */
    public $isSendToWeibo;
    protected $_oldTags;
    protected $_tocs;
    
    /**
     * Returns the static model of the specified AR class.
     * @return ArticleAR the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{article}}';
    }

    public function behaviors() {
        return array(
            'AutoTimestampBehavior' => array(
                'class' => 'AutoTimestampBehavior',
            )
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category, type, user_id, create_date, modify_date, hits', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('tags', 'length', 'max' => 255),
            array('content,isSendToWeibo', 'safe'),
            array('title,category,content','required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, category, type, user_id, content, create_date, modify_date, tags, hits', 'safe', 'on' => 'search'),
        );
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

    /**
     * @return array 关系规则.
     */
    public function relations() {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'user_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'article_id', 'order' => 'comments.modify_date DESC'),
            'commentCount' => array(self::STAT, 'Comment', 'article_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => '标题',
            'category' => '分类',
            'user_id' => '作者',
            'content' => '内容',
            'create_date' => '发布时间',
            'modify_date' => '修改时间',
            'tags' => '标签',
            'hits' => '浏览量',
            'commentCount' => '评论数',
            'rating' => '评分(支持/反对)',
            'isSendToWeibo' => '是否发送到微博',
            'type' => '文章类型',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('category', $this->category);
        $criteria->compare('type', $this->type);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('create_date', $this->create_date);
        $criteria->compare('modify_date', $this->modify_date);
        $criteria->compare('tags', $this->tags, true);
        $criteria->compare('hits', $this->hits);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'modify_date desc,create_date desc'
            )
        ));
    }

    /**
     * 返回文章的相对 URL
     * @return string 文章的相对 URL
     */
    public function getUrl() {
        switch ($this->type) {
            case self::TYPE_NEWS:
                $route = '/news/view';
                break;
            case self::TYPE_WIKI:
                $route = '/wiki/view';
                break;
            default:
                $route = '/wiki/view';
        }
        return Yii::app()->createUrl($route, array('id' => $this->id, 'title' => $this->title));
    }

    /**
     * 返回指定格式的发布时间
     * @return string 指定格式的时间
     */
    public function getCreateDate() {
        return Util::date($this->create_date);
    }

    /**
     * 返回指定格式修改时间
     * @return string 指定格式的时间
     */
    public function getModifyDate() {
        return Util::date($this->modify_date);
    }

    /**
     * 返回文章内容的摘要
     *
     * 摘要内容时经过 {@linkCMarkdownParser MarkdownParser} 处理以后的内容
     *
     * @param integer $length 摘要的字数
     * @return string 文章内容的摘要
     */
    public function getSummary($length = 300) {
        $markdown = new MarkdownParser();
        $content = $markdown->transform($this->content);
        return Util::substring($content, $length, '');
    }

    /**
     * 返回文章的标签链接数组
     * @return array 由文章的标签的链接组成的数组
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

    /**
     * 返回文章的绝对 URL
     * @return string 文章的绝对 URL
     */
    public function getAbsoluteUrl() {
        return Yii::app()->createAbsoluteUrl('/wiki/view', array('id' => $this->id, 'title' => $this->title));
    }

    /**
     * 返回文章的标题链接
     *
     * 链接的显示文字为文章的 {@link Article::title 标题}, URL 地址为文字的 {@link Article::getUrl 相对URL}
     *
     * @param boolean $isNewPage 是否从新页面打开, 默认为 false
     * @return string 文章的标题链接
     */
    public function getTitleLink($isNewPage = false) {
        if ($isNewPage)
            $htmlOptions = array("target" => "_blank");
        else
            $htmlOptions = array();
        return CHtml::link($this->title, $this->getUrl(), $htmlOptions);
    }

    /**
     * 获取高亮显示的标题
     * 显示的高亮文字为 $_GET['keywords'] 的文字
     *
     * @return string 高亮显示的标题
     */
    public function getTitle() {
        if (isset($_GET['SearchForm']['keywords']) && strpos($_GET['SearchForm']['keywords'], $this->title) === false) {
            $keywords = $_GET['SearchForm']['keywords'];
            return str_ireplace($keywords, CHtml::tag('span', array('class' => 'keywords'), $keywords), $this->title);
        }else
            return $this->title;
    }

    /**
     * 向此文章添加一条评论.
     * @param Comment 将要添加的评论
     * @return boolean 评论是否添加成功
     */
    public function addComment($comment) {
        $comment->article_id = $this->id;
        return $comment->save();
    }

    public function getTocs($refresh = false){
        if(isset($this->_tocs) || $refresh)
            return $this->_tocs;
        else{
            $mkd = new MarkdownParser();
            $mkd->transform($this->content);
            $tocs = array();
            foreach($mkd->getTocs() as $value){
                $tocs[] = new Toc($this, $value['label'], $value['level'], $value['id']);
            }
            $this->_tocs = $tocs;
            return $this->_tocs;
        }
    }

    public function getTocsView(){
        $tocs = array();
        foreach($this->getTocs() as $toc){
            $tocs[] = CHtml::tag('div',array('class'=>"level{$toc->level}"),CHtml::link($toc->label,'#'.$toc->id));
        }
        return CHtml::tag('div',array('class'=>'tocs'),implode('', $tocs));
    }

    public function hasTocs(){
        $mkd = new MarkdownParser();
        $mkd->transform($this->content);
        return count($mkd->getTocs())>0;
    }

    public function isFollowed() {
        return UserFav::favExists($this->id, UserFav::TYPE_FOLLOW);
    }

    public function getWeiboContent() {
        return "『Yii中文百科』 - " . $this->title . "。查看地址： " . $this->getAbsoluteUrl();
    }

    public function getKeywords() {
        return CMap::mergeArray(Yii::app()->params['site']['keywords'], Tag::string2array($this->tags));
    }

}

class Toc{
    //CHtml::tag('div',array('class'=>"level{$value['level']}"),CHtml::link($value['label'],'#'.$value['id']));
    public $label,$level,$id;

    private $_article;

    public function  __construct($article,$label,$level,$id) {
        $this->_article = $article;
        $this->label = $label;
        $this->level = $level;
        $this->id = $id;
    }

    public function  __get($name) {
        $method = 'get'.  ucfirst($name);
        if(property_exists($this, $name))
            return $this->$name;
        elseif(method_exists($this,$method))
            return $this->$method();
    }

    public function getUrl(){
        return $this->_article->getUrl()."#".$this->id;
    }

    public function getChmUrl(){
        return $this->_article->id.'.html#'.$this->id;
    }

}