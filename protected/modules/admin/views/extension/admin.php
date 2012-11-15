<?php
$this->breadcrumbs=array(
	'扩展管理'=>array('admin'),
	'所有扩展',
);
$this->pageTitle = '所有扩展'.$this->titleSeparator.'扩展管理 -';
?>

<h1>所有扩展</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'extension-grid',
	'dataProvider'=>$model->search(),
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
        'hits',
        array(
            'name'=>'modify_date',
            'value'=>'$data->getModifyDate()'
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
