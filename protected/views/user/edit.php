<?php
$this->layout = 'user';

$this->pageTitle = "修改个人资料".$this->titleSeparator."个人中心".$this->titleSeparator.Yii::app()->name;

$this->breadcrumbs=array(
	'个人中心'=>array('home'),
	'修改个人资料',
);

?>

<h1>修改个人资料</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>