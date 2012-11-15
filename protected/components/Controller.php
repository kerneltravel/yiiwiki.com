<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * 标题上的分隔符
     * @var string 默认为 " | "
     */
    public $titleSeparator = ' | ';

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    /**
     * 页面的描述
     * @var stirng
     */
    private $_description;
    private $_keywords = array();

    public function invalidActionParams($action)
	{
		throw new CHttpException(400,'该网页不存在');
	}

    /**
     * 返回网页的描述,如果没有设置则返回应用名
     * @return string 网页的描述
     */
    public function getDescription(){
        return empty($this->_description)?Yii::app()->name:$this->_description;
    }

    public function getKeywords(){
        $keywords = count($this->_keywords)>0 ? CMap::mergeArray(Yii::app()->params['site']['keywords'] , $this->_keywords) : Yii::app()->params['site']['keywords'];
        if(is_array($keywords))
            return implode (', ', $keywords);
        elseif(is_string($keywords))
            return $keywords;
    }

    /**
     * 设置网页的描述
     * @param string $value 描述
     */
    public function setDescription($value){
        $this->_description = $value;
    }

    public function setKeywords($keywords){
        if(is_array($keywords))
            $this->_keywords = $keywords;
        elseif(is_string($keywords))
            $this->_keywords = explode(',', $keywords);
    }

    public function addKeyword($keyword){
        $this->_keywords[] = $keyword;
    }
    
    public function getMenu(){
        return array(
            array('label'=>'主页', 'url'=>array('/site/index')),
            array('label'=>'教程','url'=>array('/wiki/index')),
            array('label'=>'新闻', 'url'=>array('/news/index')),
            array('label'=>'扩展', 'url'=>array('/extension/index')),
            array('label'=>'快速查看', 'url'=>array('/doc/index')),
            array('label'=>'下载网站源码','url'=>array('/site/page', 'view'=>'download')),
            array('label'=>'友情链接','url'=>array('/link/index')),
            array('label'=>'帮助', 'url'=>array('/page/index')),
        );
    }

    public function setMenu($value){
        
    }

    public function  init() {
        parent::init();
        /*if(isset($_GET['theme']))
            Yii::app()->theme = $_GET['theme'];*/
    }
}