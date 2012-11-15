<?php

/**
 * 描述 ArticleInfo
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */

Yii::import('zii.widgets.CPortlet');

class ArticleInfo extends CPortlet{

    public $article;
    
    protected function renderContent()
	{
        $article = $this->article;
        $items = array();
        
        if(Yii::app()->controller->id=='wiki'){
            $items[] = CHtml::link('修改此文章',array('/wiki/update','id'=>$article->id));
            if(strpos(Yii::app()->controller->getRoute(), 'history') !== false)
                $items[] = CHtml::tag('b',array(),'查看历史版本');
            else
                $items[] = CHtml::link('查看历史版本',array('/wiki/history','id'=>$article->id));

            $items[] = '<hr />';
        }
        if($article->type == ArticleAR::TYPE_WIKI){
            $items[] = CHtml::tag('b',array(),'作者').' : '.$article->author->getNameLink();
            $items[] = CHtml::tag('b',array(),'最后修改').' : '.$article->getLastVersionModel()->author->getNameLink();
        }
        $items[] = CHtml::tag('b',array(),'分类').' : '.$article->getCategoryLink();
        $items[] = CHtml::tag('b',array(),'浏览').' : '.$article->hits.' 次';
        $items[] = CHtml::tag('b',array(),'发布时间').' : '.$article->getCreateDate();
        $items[] = CHtml::tag('b',array(),'最后修改').' : '.$article->getModifyDate();
        $items[] = CHtml::tag('b',array(),'标签').' : '.implode(', ', $article->getTagLinks());

        echo CHtml::tag('ul',array(),  "<li>\n".implode("</li>\n<li>", $items)."</li>\n");
	}
}