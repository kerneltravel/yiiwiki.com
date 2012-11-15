<?php
$this->breadcrumbs=array(
	'友情链接管理'=>array('admin'),
	'添加链接',
);

$this->pageTitle = "添加链接".$this->titleSeparator;
?>

<h1>添加链接</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>