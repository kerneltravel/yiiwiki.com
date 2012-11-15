<?php
$this->pageTitle = $title.'扩展'.$this->titleSeparator.Yii::app()->name;

$this->description = $this->pageTitle;

$this->addKeyword('扩展');
$this->addKeyword('extension');
$this->breadcrumbs=array(
	'扩展'=>array('/extension/index'),
);

?>

<h1>扩展</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
