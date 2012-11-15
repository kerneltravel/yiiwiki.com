<?php
$this->breadcrumbs=array(
	'友情链接'=>array('/link/index'),
	'申请友情链接',
);
$this->pageTitle = '申请友情链接'.$this->titleSeparator;
$this->description = '申请友情链接';
$this->addKeyword('申请友情链接');
?>

<h1>申请友情链接</h1>

<?php if(Yii::app()->user->hasFlash('message')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('message'); ?>
</div>

<?php else: ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php endif;?>