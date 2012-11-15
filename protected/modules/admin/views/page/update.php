<?php
$this->breadcrumbs=array(
	'页面管理'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'修改',
);
$this->pageTitle = "修改 | ".$model->title.' | 页面管理 - ';
?>

<h1>修改页面 <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>