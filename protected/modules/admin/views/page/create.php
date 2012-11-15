<?php
$this->breadcrumbs=array(
	'页面管理'=>array('admin'),
	'新页面',
);
$this->pageTitle = "新页面 | 页面管理 - ";
?>

<h1>新页面</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>