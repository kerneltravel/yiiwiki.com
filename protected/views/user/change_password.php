<?php
$this->layout = 'user';

$this->pageTitle = "修改密码".$this->titleSeparator."个人中心".$this->titleSeparator.Yii::app()->name;

$this->breadcrumbs=array(
	'个人中心'=>array('home'),
	'修改密码',
);

?>

<h1>修改密码</h1>

<?php echo $this->renderPartial('_form_changePassword', array('model'=>$model)); ?>