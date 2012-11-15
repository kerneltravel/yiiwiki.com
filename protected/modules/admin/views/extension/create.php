<?php
$this->breadcrumbs=array(
	'扩展管理'=>array('admin'),
	'发布扩展',
);
$this->pageTitle = '发布扩展'.$this->titleSeparator.'扩展管理 -';
?>

<h1>发布扩展</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>