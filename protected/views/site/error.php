<?php
$this->pageTitle='错误'.$this->titleSeparator.Yii::app()->name;
$this->breadcrumbs=array(
	'错误',
);
?>


<div class="error">
<?php echo CHtml::encode($message); ?>
</div>