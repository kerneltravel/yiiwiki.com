<?php
$this->breadcrumbs=array(
	'所有文章'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'修改',
);

?>

<h1>修改文章 #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>