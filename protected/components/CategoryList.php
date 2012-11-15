<?php

/**
 * 描述 CategoryList
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */

Yii::import('zii.widgets.CPortlet');

class CategoryList extends CPortlet{
    
    public $title = "分类";

    public $type = Article::CATEGORY_TYPE;


    protected function renderContent()
	{
        $categories = $this->getCategories();
        echo "<ul>\n";
        foreach($categories as $key=>$value){
            echo "<li>\n";
            if($_GET['category'] != $key)
                echo CHtml::link($value, $this->getCategoryUrl($key));
            else
                echo CHtml::tag('b',array(),$value);

            echo CHtml::tag('span',array()," ({$this->getArticleCount($key)}) ");
            echo "</li>\n";
        }

        echo "</ul>";
	}

    protected function getCategories(){
        return Lookup::items($this->type);
    }

    protected function getCategoryUrl($categoryCode){
        switch($this->type){
            case News::CATEGORY_TYPE:
                return News::createCategoryUrl($categoryCode);
                break;
            case Article::CATEGORY_TYPE:
                return Article::createCategoryUrl($categoryCode);
                break;
        }
    }

    protected function getArticleCount($categoryCode){
        switch($this->type){
            case News::CATEGORY_TYPE:
                return News::getCountByCategory($categoryCode);
                break;
            case Article::CATEGORY_TYPE:
                return Article::getCountByCategory($categoryCode);
                break;
        }
    }
}