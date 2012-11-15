<?php

/**
 * 描述 Menu
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */
Yii::import('zii.widgets.CMenu');
class Menu extends CMenu{
    
    protected function renderMenu($items)
	{
		if(count($items))
		{
            
			echo CHtml::openTag('ul',$this->htmlOptions)."\n";
            echo CHtml::tag('li',array('class'=>'menu-left'),'')."\n";
			$this->renderMenuRecursive($items);
            echo CHtml::tag('li',array('class'=>'menu-right'),'')."\n";
			echo CHtml::closeTag('ul');
		}
	}
}
