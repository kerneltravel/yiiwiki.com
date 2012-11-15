<?php
$this->breadcrumbs=array(
	'帮助',
);
$this->pageTitle = '帮助'.$this->titleSeparator.Yii::app()->name;
?>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
