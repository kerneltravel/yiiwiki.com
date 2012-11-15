<?php
$this->breadcrumbs=array(
	'CHM文档管理'=>array('admin'),
	'所有文档',
);

$this->pageTitle = "所有文档".$this->titleSeparator;
?>

<h1>所有chm文档</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'chm-grid',
	'dataProvider'=>$model->search(),
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
	'columns'=>array(
		'id',
		'name',
		'article_count',
		array(
            'name'=>'url',
            'type'=>'html',
            'value'=>'CHtml::link($data->url,$data->url)'
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}',
            'updateButtonUrl'=>'Yii::app()->controller->createUrl("edit",array("id"=>$data->id))'
		),
	),
)); ?>
