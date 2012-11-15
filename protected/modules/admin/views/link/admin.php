<?php
$this->breadcrumbs=array(
	'友情链接管理'=>array('admin'),
	'所有链接',
);
$this->pageTitle = '所有链接'.$this->titleSeparator;
?>

<h1>所有链接</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'link-grid',
	'dataProvider'=>$model->search(),
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
            'header'=>'网站',
            'class'=>'CLinkColumn',
            'labelExpression'=>'$data->title',
            'urlExpression'=>'$data->getUrl()',
            'linkHtmlOptions'=>array(
                'target'=>'_blank'
            )
        ),
        array(
            'name'=>'status',
            'type'=>'html',
            'value'=>'$data->getStatusView()',
            'filter'=>  Lookup::items(Link::ADMIN_TYPE),
        ),
		'email',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}',
            'updateButtonLabel'=>'查看/修改',
            'updateButtonImageUrl'=>false,
		),
	),
)); ?>
