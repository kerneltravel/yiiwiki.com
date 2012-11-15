<?php
$this->pageTitle = '修改文章'.$this->titleSeparator.Yii::app()->name;

$this->breadcrumbs=array(
	$model->title=>$model->url,
	'修改',
);

?>

<h1>修改文章 <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form_revision', array('model'=>$model)); ?>