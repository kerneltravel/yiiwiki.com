<?php
$this->breadcrumbs=array(
	'模块管理'=>array('admin'),
	'所有模块',
);

?>

<h1>所有模块</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'module-grid',
	'dataProvider'=>$model->search(),
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
	'columns'=>array(
		'id',
		'name',
		'screen_name',
		array(
            'name'=>'status',
            'type'=>'html',
            'value'=>'$data->getStatusNameWithColor()'
        ),
		/*
		'option',
		*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}{update}',
            'updateButtonImageUrl'=>false,
            'viewButtonImageUrl'=>false,
		),
	),
)); ?>
