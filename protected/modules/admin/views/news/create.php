<?php
$this->breadcrumbs=array(
	'新闻管理'=>array('admin'),
	'添加新闻',
);
$this->pageTitle = '添加新闻'.$this->titleSeparator;
?>

<h1>添加新闻</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>