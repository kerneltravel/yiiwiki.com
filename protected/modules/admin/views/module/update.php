<?php
$this->breadcrumbs=array(
	'模块管理'=>array('admin'),
	'`'.$model->screen_name.'` 模块'=>array('view','id'=>$model->id),
	'修改',
);

?>

<h1>修改模块 <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>