<?php
$this->pageTitle = '注册 - ' . Yii::app()->name;
$this->breadcrumbs=array(
	'注册用户'=>array('register'),
);
?>

<h1>注册用户</h1>

<?php echo $this->renderPartial('_register_form', array('model'=>$model)); ?>