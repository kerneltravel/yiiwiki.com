<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of YWPager
 *
 * @author zhangd
 */
class YWPager extends CLinkPager{
    public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel="下一页";
		if($this->prevPageLabel===null)
			$this->prevPageLabel="上一页";
		if($this->firstPageLabel===null)
			$this->firstPageLabel="第一页";
		if($this->lastPageLabel===null)
			$this->lastPageLabel="最后一页";
		if($this->header===null)
			$this->header='&nbsp;';

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='ywPager';
	}
    
    public function  registerClientScript() {
        $path = Yii::app()->assetManager->publish(dirname(__FILE__).'/resources');
        Yii::app()->getClientScript()->registerCssFile($path.'/pager.css');
    }

    protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		$buttons[]=$this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false,true);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false,true);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false,true);

		// last page
		$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false,true);

		return $buttons;
	}
    
    protected function createPageButton($label,$page,$class,$hidden,$selected,$isImage = false)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
        if($isImage){
            return '<li class="'.$class.'">'.CHtml::link('&nbsp;',$this->createPageUrl($page),array('title'=>$label)).'</li>';
        }
		return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page),array('title'=>$label)).'</li>';
	}
}
?>
