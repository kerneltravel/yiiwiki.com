<?php
$this->breadcrumbs=array(
	'扩展管理'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'修改',
);

?>

<h1>修改 #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>