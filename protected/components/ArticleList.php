<?php

/**
 * 描述 ArticleList
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */

Yii::import('zii.widgets.CPortlet');

class ArticleList extends CPortlet{
    
    public $title = "最新文章";
    public $type = Article::TYPE_WIKI;
    public $style = 'default';
    public $sort = 'modify_date desc,create_date desc';
    public $max = 10;

    public function init()
	{
        $this->htmlOptions['class'] .= ' '.$this->style;
        parent::init();
	}

    protected function renderContent()
	{
        $articles = $this->getArticles();
        echo "<ul>\n";
        foreach($articles as $key=>$article){
            echo "<li>\n";
            echo CHtml::link(CHtml::encode($article->title), $article->getUrl());
            echo "</li>\n";
        }

        echo "</ul>";
	}

    protected function getArticles(){
        return ArticleAR::model()->findAll("type=:type order by {$this->sort} limit :limit",array(':type'=>$this->type,':limit'=>$this->max));
    }
}
?>
