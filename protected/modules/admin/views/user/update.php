<?php
$this->breadcrumbs=array(
	'所有用户'=>array('admin'),
	$model->username=>array('view','id'=>$model->id),
	'修改用户信息',
);

?>

<h1>修改用户信息 #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>