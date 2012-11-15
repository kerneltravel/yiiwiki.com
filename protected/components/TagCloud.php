<?php

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CPortlet
{
    public $title = '热门标签';
	public $maxTags=20;
    public $styleType = 1;
    public $tagRoute = '/site/tag';

    const STYLE_TYPE_CLOUD = 1;
    const STYLE_TYPE_LIST = 2;

	protected function renderContent()
	{
		$tags=Tag::model()->findTagWeights($this->maxTags);
        switch ($this->styleType){
            case self::STYLE_TYPE_CLOUD:
                echo $this->renderTypeOfCloud($tags);
                break;
            case self::STYLE_TYPE_LIST:
                echo $this->renderTypeOfList($tags);
                break;
        }
		
	}

    protected function renderTypeOfCloud(array $tags){
        $tagsString = '';
        foreach($tags as $tag=>$weight)
		{
			$tagsString .= CHtml::tag('span', array(
				'class'=>'tag',
				'style'=>"font-size:{$weight}pt",
			), $this->getTagLink($tag))."\n";
		}
        return $tagsString;
    }

    protected function renderTypeOfList(array $tags){
        $tagsString = "<ul>";
        foreach($tags as $tag=>$weight){
            $tagsString .= "<li>";
            $tagsString .= $this->getTagLink($tag);
            $tagsString .= '</li>';
        }
        return $tagsString;
    }

    protected function getTagLink($tag){
        return CHtml::link(CHtml::encode($tag), array($this->tagRoute,'tag'=>$tag));
    }

}