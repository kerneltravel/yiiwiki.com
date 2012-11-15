<?php
$this->breadcrumbs=array(
	'CHM文档管理'=>array('admin'),
	'发布新chm下载',
);

$this->pageTitle = "发布新chm下载".$this->titleSeparator;
?>

<h1>发布新chm下载</h1>

<?php
$this->renderPartial("_form",array('model'=>$model));
?>
