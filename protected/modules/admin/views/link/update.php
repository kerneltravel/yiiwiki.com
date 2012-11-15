<?php
$this->breadcrumbs=array(
	'友情链接管理'=>array('admin'),
	'查看/修改链接',
);
$this->pageTitle = '查看/修改链接 '.$this->titleSeparator;
?>

<h1>查看/修改链接 <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>