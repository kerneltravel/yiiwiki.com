<?php
$this->breadcrumbs=array(
	'页面管理'=>array('admin'),
	'所有页面',
);
$this->pageTitle = '页面管理 - ';
?>

<h1>所有页面</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'page-grid',
	'dataProvider'=>$model->search(),
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'sort',
		array(
            'name'=>'create_date',
            'value'=>'$data->getCreateDate()'
        ),
		array(
            'name'=>'modify_date',
            'value'=>'$data->getModifyDate()'
        ),
		array(
			'class'=>'CButtonColumn',
            'deleteConfirmation'=>'确定删除？'
		),
	),
)); ?>
