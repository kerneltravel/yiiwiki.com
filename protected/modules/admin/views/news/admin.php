<?php
$this->breadcrumbs=array(
	'新闻管理',
	'所有新闻',
);
$this->pageTitle = '所有新闻';
?>

<h1>所有新闻</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'id',
            'headerHtmlOptions'=>array(
                'style'=>'width:40px'
            ),
        ),
        array(
            'name'=>'type',
            'value'=>'LookUp::item(News::TYPE_TYPE, $data->type)',
            'filter'=>Lookup::items(News::TYPE_TYPE),
            'headerHtmlOptions'=>array(
                'style'=>'width:80px'
            ),
        ),
		array(
            'name'=>'title',
        ),
        array(
            'name'=>'create_date',
            'value'=>'$data->getCreateDate()',
            'filter'=>false,
            'headerHtmlOptions'=>array(
                'style'=>'width:100px'
            ),
        ),
        array(
            'name'=>'modify_date',
            'value'=>'$data->getModifyDate()',
            'filter'=>false,
            'headerHtmlOptions'=>array(
                'style'=>'width:100px'
            ),
        ),
		array(
			'class'=>'CButtonColumn',
            'header'=>'选项',
            'viewButtonImageUrl'=>false,
            'updateButtonImageUrl'=>false,
            'deleteButtonImageUrl'=>false,
            'template'=>'[{view}] [{update}] [{delete}]',
            'headerHtmlOptions'=>array(
                'style'=>'width:120px'
            ),
		),
	),
)); ?>
